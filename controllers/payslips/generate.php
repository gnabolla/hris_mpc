<?php
// File: controllers/payslips/generate.php

session_start();

// Make sure only admin can generate payroll
require_once __DIR__ . '/../..//functions.php';
ensureLoggedIn();
requireRole('admin');

// Load DB config & class
$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

// If this is a POST request from a form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $period_start = $_POST['period_start'] ?? null;
    $period_end   = $_POST['period_end'] ?? null;

    // Validate dates
    if (!$period_start || !$period_end) {
        // Handle error (missing dates)
        $_SESSION['error'] = "Please provide both start and end dates.";
        header("Location: /payroll"); // or wherever your form is
        exit();
    }

    // 1) Fetch all employees
    $employees = $db->select('employees');

    // 2) For each employee, compute pay within the date range
    foreach ($employees as $employee) {
        $employeeId = $employee['id'];

        // We assume 'salary' in employees table is monthly if pay_type='Monthly',
        // daily if pay_type='Daily', or hourly if pay_type='Hourly'.

        // 3) Gather attendance logs in the date range
        $logs = $db->query("
            SELECT * 
            FROM attendance_logs
            WHERE employee_id = :employee_id
              AND DATE(timestamp) BETWEEN :start AND :end
            ORDER BY timestamp ASC
        ", [
            'employee_id' => $employeeId,
            'start'       => $period_start,
            'end'         => $period_end
        ])->fetchAll();

        // We will process logs day by day
        $currentDay      = $period_start;
        $totalDays       = 0;
        $totalHours      = 0.0;
        $lateDeductions  = 0.0;
        $totalLates      = 0; // optional
        $dayLogs         = []; // grouping logs by date

        // Group logs by date
        foreach ($logs as $log) {
            $dateKey = date('Y-m-d', strtotime($log['timestamp']));
            $dayLogs[$dateKey][] = $log;
        }

        // Let's iterate from period_start to period_end (inclusive)
        // building a range of dates to ensure we handle days with no logs or partial logs
        $startTime = strtotime($period_start);
        $endTime   = strtotime($period_end);
        
        for ($time = $startTime; $time <= $endTime; $time += 86400) {
            $date = date('Y-m-d', $time);
            
            // If no logs at all for this date, the employee is absent
            if (!isset($dayLogs[$date])) {
                continue; 
            }

            // We'll try to fetch the morning clock_in/clock_out
            // and the afternoon clock_in/clock_out
            // By your requirement:
            //  - Morning: must clock_in on/before 7:30 AM (late if after)
            //             must clock_out around 12:00 PM
            //  - Afternoon: clock_in after 12 PM but before 1 PM (late if 1 PM or after)
            //               clock_out after 5 PM

            $logsForDay = $dayLogs[$date];
            // Sort by timestamp ascending
            usort($logsForDay, function ($a, $b) {
                return strtotime($a['timestamp']) <=> strtotime($b['timestamp']);
            });

            // Track clock-ins and outs
            // (We assume your system logs them in the correct order: clock_in, then clock_out, etc.)
            // We'll try to find the earliest "clock_in" before 12pm as morning in,
            // the next "clock_out" before 12pm as morning out,
            // then the earliest "clock_in" after 12pm as afternoon in,
            // then the next "clock_out" after that as afternoon out, etc.

            $morningIn  = null;
            $morningOut = null;
            $afternoonIn  = null;
            $afternoonOut = null;

            foreach ($logsForDay as $attendance) {
                $ts  = strtotime($attendance['timestamp']);
                $hm  = date('H:i', $ts);
                $type = $attendance['event_type'];

                // We'll do a simple approach:
                // Check if it's before noon or after noon
                if ($type === 'clock_in') {
                    if (!$morningIn && date('H:i', $ts) < '12:00') {
                        $morningIn = $ts;
                    } 
                    elseif (!$afternoonIn && date('H:i', $ts) >= '12:00') {
                        $afternoonIn = $ts;
                    }
                } else { // clock_out
                    if (!$morningOut && $morningIn && date('H:i', $ts) <= '12:30') {
                        // We give a bit of buffer (12:30) in case they log exactly 12:05 or so
                        $morningOut = $ts;
                    }
                    elseif (!$afternoonOut && $afternoonIn && date('H:i', $ts) >= '12:00') {
                        $afternoonOut = $ts;
                    }
                }
            }

            // Compute morning hours
            // The ideal schedule for morning: 7:30 to 12:00 -> 4.5 hours
            $morningHours = 0.0;
            if ($morningIn && $morningOut) {
                // For lateness check
                // If morningIn is after 7:30, it's late
                $expectedMorningIn = strtotime($date . ' 07:30:00');
                if ($morningIn > $expectedMorningIn) {
                    $totalLates++;
                    // Deduction logic if you want to penalize by minute or by fraction
                    // e.g. for every minute late, deduct = (salary / totalWorkingMinutes) * lateMinutes
                    // We'll keep it simple, say 1 hour of pay deducted if you're late any time after 7:30
                    // Adjust as you see fit
                    $lateDeductions += $this->computeLateDeduction($employee, 1.0); 
                }

                // Calculate actual morning hours
                // e.g. difference between morningIn and morningOut in hours
                $diffSec = $morningOut - $morningIn;
                $morningHours = round($diffSec / 3600, 2);
            }

            // Compute afternoon hours
            // The ideal schedule for afternoon: 1:00 to 5:00 -> 4 hours
            $afternoonHours = 0.0;
            if ($afternoonIn && $afternoonOut) {
                // If afternoonIn is at or after 13:00:00, that's a late for the afternoon
                $expectedAfternoonIn = strtotime($date . ' 13:00:00');
                if ($afternoonIn >= $expectedAfternoonIn) {
                    $totalLates++;
                    // Another optional deduction
                    $lateDeductions += $this->computeLateDeduction($employee, 0.5); 
                }

                $diffSec = $afternoonOut - $afternoonIn;
                $afternoonHours = round($diffSec / 3600, 2);
            }

            // If the employee has any hours for that day, we consider them as present (for daily or monthly)
            $dailyHours = $morningHours + $afternoonHours;
            if ($dailyHours > 0) {
                $totalDays += 1;
                $totalHours += $dailyHours;
            }
        }

        // Now compute the pay
        // Convert monthly to daily, daily to daily, or hourly
        $grossPay = 0.0;

        if ($employee['pay_type'] === 'Monthly') {
            // E.g. assume 26 working days in a month 
            $dailyRate = floatval($employee['salary']) / 26.0;
            $grossPay  = $dailyRate * $totalDays;
        }
        elseif ($employee['pay_type'] === 'Daily') {
            // salary column is the daily rate
            $dailyRate = floatval($employee['salary']);
            $grossPay  = $dailyRate * $totalDays;
        }
        else { // Hourly
            // salary column is the hourly rate
            $hourlyRate = floatval($employee['salary']);
            $grossPay   = $hourlyRate * $totalHours;
        }

        // Combine lateDeductions with other general deductions if you want
        // For simplicity, let "deductions" = $lateDeductions
        $deductions = $lateDeductions; 
        // We can add more: e.g. SSS, tax, etc.

        // final net
        $netPay = $grossPay - $deductions;

        // 4) Insert into payslips
        $db->insert('payslips', [
            'employee_id'   => $employeeId,
            'period_start'  => $period_start,
            'period_end'    => $period_end,
            'total_days'    => $totalDays,
            'total_hours'   => $totalHours,
            'gross_pay'     => $grossPay,
            'net_pay'       => $netPay,
            'deductions'    => $deductions,
            'late_deductions' => $lateDeductions,  // new column if you added it
            'total_lates'   => $totalLates,        // new column if you added it
        ]);
    }

    // Redirect or show a success message
    $_SESSION['success'] = "Payroll generation completed!";
    header("Location: /payroll"); 
    exit();

} else {
    // If GET request, show a form or redirect 
    header("Location: /payroll");
    exit();
}

/**
 * Helper function to compute how much to deduct for lateness 
 * You can adjust logic to do per-hour or partial
 */
private function computeLateDeduction($employee, $hoursLate)
{
    // For monthly employees, for example:
    //  1 hour late => (monthly / 26 days / 8 hours) * hoursLate
    // For daily => (salary / 8) * hoursLate
    // For hourly => hourly * hoursLate
    // This is just an example.

    $payType = $employee['pay_type'];
    $salary  = floatval($employee['salary']);

    switch ($payType) {
        case 'Monthly':
            $dailyRate  = $salary / 26.0;
            $hourlyRate = $dailyRate / 8.0;
            return $hourlyRate * $hoursLate;
        case 'Daily':
            $hourlyRate = $salary / 8.0;
            return $hourlyRate * $hoursLate;
        case 'Hourly':
        default:
            return $salary * $hoursLate;
    }
}
