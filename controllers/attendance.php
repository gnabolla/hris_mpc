<?php
session_start();

ensureLoggedIn();

// Fetch user role to ensure only employees can log attendance
if (!hasRole('employee') && !hasRole('admin')) {
    abort(403);
}

$config = require('config.php');
$db = new Database($config['database']);

// Initialize variables for response
$response = [
    'status' => 'error',
    'message' => 'Invalid request.'
];

// Check if RFID is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rfid'])) {
    $rfid = trim($_POST['rfid']);

    // Validate RFID format if necessary
    if (empty($rfid)) {
        $response['message'] = 'RFID cannot be empty.';
    } else {
        // Find the employee by RFID
        $employee = $db->query("SELECT * FROM employees WHERE rfid = :rfid", ['rfid' => $rfid])->fetch();

        if ($employee) {
            $employee_id = $employee['id'];

            // Determine the event type based on the last log
            $last_log = $db->query("SELECT event_type FROM attendance_logs WHERE employee_id = :employee_id ORDER BY timestamp DESC LIMIT 1", ['employee_id' => $employee_id])->fetch();

            if ($last_log && $last_log['event_type'] === 'clock_in') {
                $event_type = 'clock_out';
            } else {
                $event_type = 'clock_in';
            }

            // Insert the attendance log
            $db->query("INSERT INTO attendance_logs (employee_id, event_type) VALUES (:employee_id, :event_type)", [
                'employee_id' => $employee_id,
                'event_type' => $event_type
            ]);

            $response['status'] = 'success';
            $response['message'] = "Attendance recorded: {$event_type}.";
        } else {
            $response['message'] = 'Invalid RFID. Employee not found.';
        }
    }
}

// If the request is AJAX, return JSON
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// For regular POST requests, redirect back with a message (optional)
header('Location: /attendance');
exit();
?>
