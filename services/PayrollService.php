<?php
// services/PayrollService.php (REVISED)

class PayrollService
{
    protected $db; // store database connection

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Generate monthly payslips for all employees within the given year/month.
     */
    public function generateMonthlyPayslips($year, $month)
    {
        // 1) Determine period_start & period_end
        $periodStart = "{$year}-{$month}-01";
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $periodEnd = "{$year}-{$month}-{$numDays}";

        // 2) Fetch employees you'd like to pay (e.g., active staff)
        $employees = $this->db->query("
           SELECT *
           FROM employees
           WHERE employment_status IN ('Full-time','Part-time','Contractual')
        ")->fetchAll();

        // 3) Loop each employee, do calculations, insert into `payslips`
        foreach ($employees as $emp) {
            $calculated = $this->calculatePayForPeriod($emp, $periodStart, $periodEnd);

            // Insert a new payslip record
            $this->db->query("
                INSERT INTO payslips (
                    employee_id, period_start, period_end,
                    total_days, total_hours,
                    gross_pay, deductions, net_pay
                ) VALUES (
                    :emp_id, :start, :end,
                    :days, :hours,
                    :gross, :ded, :net
                )
            ", [
                'emp_id' => $emp['id'],
                'start'  => $periodStart,
                'end'    => $periodEnd,
                'days'   => $calculated['total_days'],
                'hours'  => $calculated['total_hours'],
                'gross'  => $calculated['gross'],
                'ded'    => $calculated['deductions'],
                'net'    => $calculated['net'],
            ]);
        }

        return "Payslips generated for {$year}-{$month}.";
    }

    /**
     * Calculation logic: Daily, Hourly, or Monthly pay + late/absent deductions, etc.
     * 
     * Revised to handle partial-day logic, reduced lateness penalty,
     * and a cap on total deductions.
     */
    public function calculatePayForPeriod($employee, $startDate, $endDate)
    {
        // 1) fetch attendance logs
        $attendanceLogs = $this->db->query("
            SELECT *
            FROM attendance_logs
            WHERE employee_id = :eid
              AND timestamp BETWEEN :start AND :end
            ORDER BY timestamp ASC
        ", [
            'eid'   => $employee['id'],
            'start' => $startDate . ' 00:00:00',
            'end'   => $endDate . ' 23:59:59',
        ])->fetchAll();

        // 2) group logs by day
        $daysData = $this->parseAttendanceByDay($attendanceLogs);

        // Basic policy
        $monthlyWorkDays = 22; // example default
        $payType = $employee['pay_type']; // "Monthly", "Daily", or "Hourly"
        $rate    = (float)$employee['salary'];

        // accumulators
        $absentCount      = 0;    // Number of *completely* absent days
        $totalDaysWorked  = 0.0;  // Now a float to account for partial days
        $totalHoursWorked = 0;
        $lateDeductions   = 0;

        // 3) Generate list of *all* days from $startDate to $endDate
        $start = new \DateTime($startDate);
        $end   = new \DateTime($endDate);
        // include the end date in the loop
        $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $period   = new \DatePeriod($start, $interval, $end);

        // standard "full day" hours
        $fullDayHours = 8;

        foreach ($period as $dayObj) {
            $dayKey = $dayObj->format('Y-m-d');

            // If there's *no* log for this day => absent
            if (!isset($daysData[$dayKey])) {
                $absentCount++;
                continue;
            }

            // We do have logs for this day
            $dayHours = $this->calculateDayHours($daysData[$dayKey]);

            // If hours = 0, treat as fully absent
            if ($dayHours <= 0) {
                $absentCount++;
                continue;
            }

            // If we got here, employee worked some hours
            // Convert hours to fraction of a full day
            $fractionOfDay = $dayHours / $fullDayHours;
            if ($fractionOfDay > 1) {
                // max at 1 day if they worked overtime
                $fractionOfDay = 1;
            }

            $totalDaysWorked += $fractionOfDay;
            $totalHoursWorked += $dayHours;

            // check lateness
            $lateOccurrences = $this->calculateDayLate($daysData[$dayKey]);
            $lateDeductions += $lateOccurrences;
        }

        // 4) Compute gross vs. net
        $gross      = 0.0;
        $deductions = 0.0;

        if ($payType === "Monthly") {
            // base monthly pay
            $gross = $rate;

            // absent penalty
            //   Each full absent day => (monthly / monthlyWorkDays)
            //   *If you want to penalize partial days, do more advanced math
            $absentPenalty = ($rate / $monthlyWorkDays) * $absentCount;

            // late penalty: each late = 0.125 day
            //   was 0.25 day in original, let's reduce to 0.125
            $latePenalty = $lateDeductions * ($rate / $monthlyWorkDays * 0.125);

            $deductions = $absentPenalty + $latePenalty;

        } elseif ($payType === "Daily") {
            // daily rate * totalDaysWorked
            // totalDaysWorked can be fractional (e.g., 20.5)
            $gross = $rate * $totalDaysWorked;

            // each late = 0.125 daily
            $latePenalty = $lateDeductions * ($rate * 0.125);
            $deductions = $latePenalty;
            // No additional absent penalty needed, 
            // because not working any hours already reduces daily pay

        } else { // "Hourly"
            // hourly rate * total hours
            $gross = $rate * $totalHoursWorked;
            // optionally define a late penalty if you want
            // for now, set no special late deduction for hourly
            $deductions = 0.0;
        }

        // 5) (Optional) Cap the total deduction to 50% of gross
        $maxDeduction = $gross * 0.5;
        if ($deductions > $maxDeduction) {
            $deductions = $maxDeduction;
        }

        // final net
        $net = $gross - $deductions;
        if ($net < 0) {
            $net = 0;
        }

        return [
            'total_days'   => round($totalDaysWorked, 2),
            'total_hours'  => round($totalHoursWorked, 2),
            'gross'        => round($gross, 2),
            'deductions'   => round($deductions, 2),
            'net'          => round($net, 2),
        ];
    }

    /**
     * Group logs by day: "YYYY-MM-DD" => [ {timestamp, event_type}, ... ]
     */
    protected function parseAttendanceByDay($logs)
    {
        $result = [];
        foreach ($logs as $log) {
            $dt = new \DateTime($log['timestamp']);
            $dateKey = $dt->format('Y-m-d');
            if (!isset($result[$dateKey])) {
                $result[$dateKey] = [];
            }
            $result[$dateKey][] = [
                'time'       => $dt,
                'event_type' => $log['event_type']
            ];
        }
        return $result;
    }

    /**
     * Calculate total hours by pairing clock_in → clock_out in a single day
     */
    protected function calculateDayHours($dayEvents)
    {
        // Sort events by time
        usort($dayEvents, function($a, $b) {
            return $a['time']->getTimestamp() <=> $b['time']->getTimestamp();
        });

        $hours = 0.0;
        $clockIn = null;
        foreach ($dayEvents as $ev) {
            if ($ev['event_type'] === 'clock_in' && !$clockIn) {
                $clockIn = $ev['time'];
            } elseif ($ev['event_type'] === 'clock_out' && $clockIn) {
                $diffSec = $ev['time']->getTimestamp() - $clockIn->getTimestamp();
                $hours += ($diffSec / 3600.0);
                $clockIn = null;
            }
        }
        // If they never clock_out, we treat it as 0 (or partial)
        // For simplicity, let's keep it at 0.
        return round($hours, 2);
    }

    /**
     * If first clock_in is after 8:00 AM, consider them late (1 occurrence).
     * We only track 1 late per day. 
     */
    protected function calculateDayLate($dayEvents)
    {
        // Sort by time
        usort($dayEvents, function($a, $b) {
            return $a['time']->getTimestamp() <=> $b['time']->getTimestamp();
        });
        foreach ($dayEvents as $ev) {
            if ($ev['event_type'] === 'clock_in') {
                // Compare to 8AM
                $eightAM = new \DateTime($ev['time']->format('Y-m-d') . ' 08:00:00');
                if ($ev['time'] > $eightAM) {
                    return 1;
                }
                break; // if not late, stop checking
            }
        }
        return 0;
    }
}
