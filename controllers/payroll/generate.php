<?php
// File: controllers/payroll/generate.php

session_start();
require_once __DIR__ . '/../../functions.php';
ensureLoggedIn();
requireRole('admin');

$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

// If not a POST request, just redirect
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /payroll");
    exit();
}

// Retrieve date range
$period_start = $_POST['period_start'] ?? null;
$period_end   = $_POST['period_end'] ?? null;

if (!$period_start || !$period_end) {
    $_SESSION['error'] = "Please provide both start and end dates.";
    header("Location: /payroll");
    exit();
}

// Convert to timestamps for iteration
$startTime = strtotime($period_start);
$endTime   = strtotime($period_end);

// Basic validation
if ($endTime < $startTime) {
    $_SESSION['error'] = "End date must be after Start date.";
    header("Location: /payroll");
    exit();
}

// 1) Fetch all employees
$employees = $db->select('employees');

// 2) For each employee, compute pay within the date range
foreach ($employees as $employee) {
    $employeeId = $employee['id'];
    $payType    = $employee['pay_type'];  // Monthly, Daily, or Hourly
    $baseSalary = floatval($employee['salary']);

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

    // Group logs by date
    $dayLogs = [];
    foreach ($logs as $log) {
        $dateKey = date('Y-m-d', strtotime($log['timestamp']));
        $dayLogs[$dateKey][] = $log;
    }

    $totalDays      = 0;
    $totalHours     = 0.0;
    $lateDeductions = 0.0;
    $totalLates     = 0; // total # of times late

    // Iterate day-by-day in the range
    for ($t = $startTime; $t <= $endTime; $t += 86400) {
        $dateStr = date('Y-m-d', $t);

        // If no logs for this date => absent
        if (!isset($dayLogs[$dateStr])) {
            continue;
        }

        // Sort logs of this day by timestamp ascending
        $logsForDay = $dayLogs[$dateStr];
        usort($logsForDay, function($a, $b) {
            return strtotime($a['timestamp']) - strtotime($b['timestamp']);
        });

        // We'll find morningIn, morningOut, afternoonIn, afternoonOut
        $morningIn    = null;
        $morningOut   = null;
        $afternoonIn  = null;
        $afternoonOut = null;

        foreach ($logsForDay as $attendance) {
            $ts   = strtotime($attendance['timestamp']);
            $type = $attendance['event_type'];
            $timeHM = date('H:i', $ts);

            if ($type === 'clock_in') {
                // If we don't have a morningIn yet & it's before 12:00
                if (!$morningIn && $timeHM < '12:00') {
                    $morningIn = $ts;
                } 
                // else if we don't have an afternoonIn yet & it's >= 12:00
                else if (!$afternoonIn && $timeHM >= '12:00') {
                    $afternoonIn = $ts;
                }
            } else { // clock_out
                // If morningOut is not set, morningIn is set, and time is <=12:30 (some buffer)
                if (!$morningOut && $morningIn && $timeHM <= '12:30') {
                    $morningOut = $ts;
                } 
                // else if afternoonOut is not set, afternoonIn is set, time >= 12:00
                else if (!$afternoonOut && $afternoonIn && $timeHM >= '12:00') {
                    $afternoonOut = $ts;
                }
            }
        }

        // Calculate morning hours (7:30-12:00)
        $morningHours = 0.0;
        if ($morningIn && $morningOut) {
            // Check for lateness: if morningIn > 07:30, late
            $expectedMorningIn = strtotime($dateStr . ' 07:30:00');
            if ($morningIn > $expectedMorningIn) {
                $totalLates++;
                // Deduct 1 hour's pay for being late in the morning
                $lateDeductions += computeLateDeduction($employee, 1.0);
            }

            // Compute hours
            $diffSec      = $morningOut - $morningIn;
            $morningHours = round($diffSec / 3600, 2);
            // Cap it at 4.5 hours if you prefer (7:30 to 12 = 4.5)
            // but let's keep it as actual
        }

        // Calculate afternoon hours (1:00-5:00)
        $afternoonHours = 0.0;
        if ($afternoonIn && $afternoonOut) {
            // Lateness check: if afternoonIn >= 13:00 => late
            $expectedAfternoonIn = strtotime($dateStr . ' 13:00:00');
            if ($afternoonIn >= $expectedAfternoonIn) {
                $totalLates++;
                // Deduct 0.5 hour's pay for being late in the afternoon
                $lateDeductions += computeLateDeduction($employee, 0.5);
            }

            // Compute hours
            $diffSec        = $afternoonOut - $afternoonIn;
            $afternoonHours = round($diffSec / 3600, 2);
            // Potentially cap at 4 hours if you want
        }

        $dailyHours = $morningHours + $afternoonHours;
        if ($dailyHours > 0) {
            $totalDays  += 1;
            $totalHours += $dailyHours;
        }
    }

    // Compute gross pay
    $grossPay = 0.0;

    switch ($payType) {
        case 'Monthly':
            // e.g. monthly rate divided by 26 working days => dailyRate
            // then multiply by totalDays
            $dailyRate = $baseSalary / 26.0;
            $grossPay  = $dailyRate * $totalDays;
            break;
        case 'Daily':
            // salary in DB is daily rate
            $dailyRate = $baseSalary;
            $grossPay  = $dailyRate * $totalDays;
            break;
        case 'Hourly':
        default:
            // salary in DB is hourly rate
            $hourlyRate = $baseSalary;
            $grossPay   = $hourlyRate * $totalHours;
            break;
    }

    // Combine lateDeductions with other general deductions if any
    // For now, we’ll keep it simple: `deductions` = $lateDeductions
    $deductions = $lateDeductions;

    // net pay
    $netPay = $grossPay - $deductions;

    // Insert into payslips
    $db->insert('payslips', [
        'employee_id'      => $employeeId,
        'period_start'     => $period_start,
        'period_end'       => $period_end,
        'total_days'       => $totalDays,
        'total_hours'      => $totalHours,
        'gross_pay'        => $grossPay,
        'deductions'       => $deductions,
        'net_pay'          => $netPay,
        'late_deductions'  => $lateDeductions,
        'total_lates'      => $totalLates,
        'created_at'       => date('Y-m-d H:i:s')  // Just in case
    ]);
}

// Done generating
$_SESSION['success'] = "Payroll generation completed for all employees!";
header("Location: /payroll");
exit();

/**
 * computeLateDeduction
 *
 * For a given employee & hoursLate, returns how much to deduct.
 * You can fine-tune the formula as you please.
 */
function computeLateDeduction($employee, $hoursLate)
{
    $payType    = $employee['pay_type'];
    $baseSalary = floatval($employee['salary']);

    switch ($payType) {
        case 'Monthly':
            // 1) Convert monthly to daily by /26
            // 2) daily to hourly by /8
            // 3) multiply by $hoursLate
            $dailyRate  = $baseSalary / 26.0;
            $hourlyRate = $dailyRate / 8.0;
            return $hourlyRate * $hoursLate;

        case 'Daily':
            // 1) daily -> hourly by /8
            // 2) multiply by $hoursLate
            $hourlyRate = $baseSalary / 8.0;
            return $hourlyRate * $hoursLate;

        case 'Hourly':
        default:
            // If salary is already hourly, multiply by hoursLate
            return $baseSalary * $hoursLate;
    }
}
