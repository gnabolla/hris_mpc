<?php
session_start();

ensureLoggedIn();
requireRole('employee');

$config = require('config.php'); // If needed, ensure the path is correct
$db = new Database($config['database']);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = trim($_POST['start_date'] ?? '');
    $end_date = trim($_POST['end_date'] ?? '');
    $reason = trim($_POST['reason'] ?? '');

    if (empty($start_date)) {
        $errors[] = 'Start date is required.';
    }
    if (empty($end_date)) {
        $errors[] = 'End date is required.';
    }
    if (empty($reason)) {
        $errors[] = 'Reason for leave is required.';
    }

    // Validate date formats
    if (!empty($start_date) && !DateTime::createFromFormat('Y-m-d', $start_date)) {
        $errors[] = 'Invalid start date format.';
    }
    if (!empty($end_date) && !DateTime::createFromFormat('Y-m-d', $end_date)) {
        $errors[] = 'Invalid end date format.';
    }

    // Ensure start_date is before or equal to end_date
    if (!empty($start_date) && !empty($end_date)) {
        if (strtotime($start_date) > strtotime($end_date)) {
            $errors[] = 'Start date cannot be after end date.';
        }
    }

    if (empty($errors)) {
        $data = [
            'employee_id' => $_SESSION['employee_id'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'reason' => $reason,
            'status' => 'Pending'
        ];

        $db->insert('leave_requests', $data);

        header('Location: /');
        exit();
    }
}

$title = 'Request Leave';
$view = 'views/leaves/request.view.php';
require 'views/layout.view.php';
?>
