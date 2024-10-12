<?php
session_start();

$config = require('config.php');
$db = new Database($config['database']);

$today = date('Y-m-d');

$clocked_in_employees = $db->query("
    SELECT e.full_name, e.image_path, MIN(al.timestamp) AS clock_in_time
    FROM attendance_logs al
    JOIN employees e ON al.employee_id = e.id
    WHERE DATE(al.timestamp) = :today AND al.event_type = 'clock_in'
    GROUP BY e.id
    ORDER BY clock_in_time ASC
", ['today' => $today])->fetchAll();

// Format clock-in times
foreach ($clocked_in_employees as &$employee) {
    $employee['clock_in_time'] = date('h:i A', strtotime($employee['clock_in_time']));
}

$response = [
    'clocked_in_employees' => $clocked_in_employees
];

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
