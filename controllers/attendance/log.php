<?php
session_start();

$config = require('config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rfid = $_POST['rfid'] ?? null;

    if ($rfid) {
        // 1) Find the employee by RFID
        $employee = $db->query(
            "SELECT * FROM employees WHERE rfid = :rfid",
            ['rfid' => $rfid]
        )->fetch();

        if ($employee) {
            // 2) Check the last attendance log for today
            $today = date('Y-m-d');
            $lastLog = $db->query("
                SELECT * 
                FROM attendance_logs 
                WHERE employee_id = :employee_id
                  AND DATE(timestamp) = :today
                ORDER BY timestamp DESC
                LIMIT 1
            ", [
                'employee_id' => $employee['id'],
                'today'       => $today
            ])->fetch();

            $currentTime   = time();
            $timestamp     = date('Y-m-d H:i:s'); // current timestamp for the next record
            $tenMinutes    = 10 * 60; // 10 minutes in seconds
            $twoMinutes    = 2 * 60;  // 2 minutes in seconds

            if (!$lastLog) {
                /*
                 * No logs yet for today → First event is a "Clock In"
                 * (Morning Clock In)
                 */
                $db->query("
                    INSERT INTO attendance_logs (employee_id, event_type, timestamp)
                    VALUES (:employee_id, 'clock_in', :timestamp)
                ", [
                    'employee_id' => $employee['id'],
                    'timestamp'   => $timestamp
                ]);

                $response = [
                    'status'  => 'success',
                    'message' => "Welcome, " . $employee['full_name'] . "! (Morning Clock In)",
                    'employee' => [
                        'full_name'     => $employee['full_name'],
                        'image_path'    => $employee['image_path'],
                        'clock_in_time' => date('h:i A', strtotime($timestamp))
                    ]
                ];
            } else {
                /*
                 * We have a prior log for today, check its event type and time.
                 */
                $lastEventType = $lastLog['event_type'];
                $lastEventTime = strtotime($lastLog['timestamp']);

                if ($lastEventType === 'clock_in') {
                    /*
                     * If the last event is "clock_in":
                     *   → If at least 10 minutes have passed, record "clock_out".
                     *   → Otherwise, show an error / or ignore.
                     */
                    if (($currentTime - $lastEventTime) >= $tenMinutes) {
                        // Record the clock_out
                        $db->query("
                            INSERT INTO attendance_logs (employee_id, event_type, timestamp)
                            VALUES (:employee_id, 'clock_out', :timestamp)
                        ", [
                            'employee_id' => $employee['id'],
                            'timestamp'   => $timestamp
                        ]);

                        $response = [
                            'status'  => 'success',
                            'message' => "Clock Out recorded for " . $employee['full_name'],
                            'employee' => [
                                'full_name'     => $employee['full_name'],
                                'image_path'    => $employee['image_path'],
                                'clock_in_time' => date('h:i A', strtotime($timestamp))
                            ]
                        ];
                    } else {
                        // Not enough time has passed
                        $waitMinutes = round(($tenMinutes - ($currentTime - $lastEventTime)) / 60);
                        $response = [
                            'status'  => 'error',
                            'message' => "You can only clock out after 10 minutes. Please wait ~{$waitMinutes} more minute(s)."
                        ];
                    }
                } else {
                    /*
                     * If the last event is "clock_out":
                     *   → If at least 2 minutes have passed, record the next "clock_in" (Afternoon).
                     *   → Otherwise, show an error / or ignore.
                     */
                    if (($currentTime - $lastEventTime) >= $twoMinutes) {
                        // Record the clock_in
                        $db->query("
                            INSERT INTO attendance_logs (employee_id, event_type, timestamp)
                            VALUES (:employee_id, 'clock_in', :timestamp)
                        ", [
                            'employee_id' => $employee['id'],
                            'timestamp'   => $timestamp
                        ]);

                        $response = [
                            'status'  => 'success',
                            'message' => "Welcome back, " . $employee['full_name'] . "! (Afternoon Clock In)",
                            'employee' => [
                                'full_name'     => $employee['full_name'],
                                'image_path'    => $employee['image_path'],
                                'clock_in_time' => date('h:i A', strtotime($timestamp))
                            ]
                        ];
                    } else {
                        // Not enough time has passed
                        $waitMinutes = round(($twoMinutes - ($currentTime - $lastEventTime)) / 60);
                        $response = [
                            'status'  => 'error',
                            'message' => "You can only clock in again after 2 minutes. Please wait ~{$waitMinutes} more minute(s)."
                        ];
                    }
                }
            }
        } else {
            // Employee not found
            $response = [
                'status'  => 'error',
                'message' => 'RFID not recognized.'
            ];
        }
    } else {
        $response = [
            'status'  => 'error',
            'message' => 'RFID is required.'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
