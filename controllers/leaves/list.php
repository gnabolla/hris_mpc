<?php
session_start();

ensureLoggedIn();
requireRole('employee');

$config = require('config.php');
$db = new Database($config['database']);

// Fetch leave requests for the logged-in employee
$leaveRequests = $db->query("
    SELECT *
    FROM leave_requests
    WHERE employee_id = :employee_id
    ORDER BY created_at DESC
", [
    'employee_id' => $_SESSION['employee_id']
])->fetchAll();

$title = 'My Leave Requests';
$view = 'views/leaves/list.view.php';
require 'views/layout.view.php';
?>
