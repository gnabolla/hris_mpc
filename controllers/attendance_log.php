<?php
session_start();

$config = require('config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rfid = $_POST['rfid'] ?? null;

    if ($rfid) {
        // Find the employee by RFID
        $employee = $db->query("SELECT * FROM employees WHERE rfid = :rfid", ['rfid' => $rfid])->fetch();

        if ($employee) {
            // Record the attendance
            $timestamp = date('Y-m-d H:i:s');
            $db->query("INSERT INTO attendance_logs (employee_id, event_type, timestamp) VALUES (:employee_id, 'clock_in', :timestamp)", [
                'employee_id' => $employee['id'],
                'timestamp' => $timestamp
            ]);

            // Prepare the response
            $response = [
                'status' => 'success',
                'message' => "Welcome, " . $employee['full_name'] . "!",
                'employee' => [
                    'full_name' => $employee['full_name'],
                    'image_path' => $employee['image_path'],
                    'clock_in_time' => date('h:i A', strtotime($timestamp))
                ]
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'RFID not recognized.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'RFID is required.'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
