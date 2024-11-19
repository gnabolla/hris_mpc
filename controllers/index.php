<?php
session_start();

ensureLoggedIn();

$config = require('config.php');
$db = new Database($config['database']);

if (hasRole('admin')) {
    $title = "Dashboard";
    $view = "views/index.view.php";
} elseif (hasRole('employee')) {
    $employeeId = $_SESSION['employee_id'];
    // Fetch the logged-in employee's data
    $employee = $db->query("SELECT * FROM employees WHERE id = :id", ['id' => $_SESSION['employee_id']])->fetch();
    
    $latestLeave = $db->query("
    SELECT * FROM leave_requests 
    WHERE employee_id = :employee_id 
    ORDER BY created_at DESC 
    LIMIT 1
", ['employee_id' => $employeeId])->fetch();

    // Fetch today's attendance
    $today = date('Y-m-d');
    $todayAttendance = $db->query("
    SELECT 
        MIN(CASE WHEN event_type = 'clock_in' THEN timestamp END) AS clock_in,
        MAX(CASE WHEN event_type = 'clock_out' THEN timestamp END) AS clock_out
    FROM attendance_logs 
    WHERE employee_id = :employee_id 
      AND DATE(timestamp) = :today
", ['employee_id' => $employeeId, 'today' => $today])->fetch();

    // Determine today's attendance status
    if (!$todayAttendance['clock_in']) {
        $attendanceStatus = 'Absent';
    } elseif (!$todayAttendance['clock_out']) {
        $attendanceStatus = 'Present (Not Clocked Out)';
    } else {
        $attendanceStatus = 'Present';
    }

    // Fetch attendance history (last 10 days)
    $attendanceHistory = $db->query("
    SELECT 
        DATE(timestamp) as date,
        event_type,
        timestamp 
    FROM attendance_logs 
    WHERE employee_id = :employee_id 
      AND DATE(timestamp) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ORDER BY timestamp DESC
", ['employee_id' => $employeeId])->fetchAll();

    // Fetch leave history (last 10 requests)
    $leaveHistory = $db->query("
    SELECT 
        * 
    FROM leave_requests 
    WHERE employee_id = :employee_id 
    ORDER BY created_at DESC 
    LIMIT 10
", ['employee_id' => $employeeId])->fetchAll();

    // Additional metrics (optional)
    $totalLeaves = $db->query("SELECT COUNT(*) as count FROM leave_requests WHERE employee_id = :employee_id", ['employee_id' => $employeeId])->fetch()['count'];
    $approvedLeaves = $db->query("SELECT COUNT(*) as count FROM leave_requests WHERE employee_id = :employee_id AND status = 'Approved'", ['employee_id' => $employeeId])->fetch()['count'];
    $pendingLeaves = $db->query("SELECT COUNT(*) as count FROM leave_requests WHERE employee_id = :employee_id AND status = 'Pending'", ['employee_id' => $employeeId])->fetch()['count'];


    $title = "My Dashboard";
    $view = "views/employees/profile.view.php";
} else {
    abort(403);
}

require "views/layout.view.php";
