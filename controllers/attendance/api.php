<?php
session_start();

ensureLoggedIn();

// Only employees and admins should access the attendance API
if (!hasRole('employee') && !hasRole('admin')) {
    abort(403);
}

$config = require('config.php');
$db = new Database($config['database']);

// Fetch the latest 10 attendance logs
$latest_logs = $db->query("
    SELECT 
        e.full_name,
        e.image_path,
        al.timestamp AS clock_in
    FROM attendance_logs al
    JOIN employees e ON al.employee_id = e.id
    WHERE al.event_type = 'clock_in'
    ORDER BY al.timestamp DESC
    LIMIT 10
")->fetchAll();


// Fetch the count of employees currently clocked in
$current_in_count = $db->query("
    SELECT COUNT(DISTINCT al.employee_id) AS count
    FROM attendance_logs al
    WHERE al.event_type = 'clock_in' 
      AND al.employee_id NOT IN (
          SELECT employee_id 
          FROM attendance_logs 
          WHERE event_type = 'clock_out'
      )
")->fetch()['count'];

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'latest_logs' => $latest_logs,
    'current_in_count' => $current_in_count
]);
exit();
?>
