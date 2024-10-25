<?php
session_start();

$config = require('config.php');
$db = new Database($config['database']);

$today = date('Y-m-d');

$clocked_in_employees = $db->query("
    SELECT 
        e.full_name, 
        e.image_path, 
        MIN(al1.timestamp) AS clock_in_time
    FROM attendance_logs al1
    JOIN employees e ON al1.employee_id = e.id
    WHERE 
        DATE(al1.timestamp) = :today 
        AND al1.event_type = 'clock_in'
        AND NOT EXISTS (
            SELECT 1 
            FROM attendance_logs al2
            WHERE 
                al2.employee_id = al1.employee_id
                AND DATE(al2.timestamp) = :today
                AND al2.event_type = 'clock_out'
                AND al2.timestamp > al1.timestamp
        )
    GROUP BY 
        e.id, 
        e.full_name, 
        e.image_path
    ORDER BY 
        clock_in_time DESC  /* Changed from ASC to DESC */
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