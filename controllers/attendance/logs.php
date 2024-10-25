<?php
session_start();

// Ensure the user is logged in and has the admin role
require_once 'functions.php';
ensureLoggedIn();
requireRole('admin');

// Get the database connection
$config = require('config.php');
$db = new Database($config['database']);

// Handle the date filter
$date = $_GET['date'] ?? date('Y-m-d');

// Validate the date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $date = date('Y-m-d');
}

// Fetch attendance logs for the specified date
$attendance_logs = $db->query("
    SELECT al.*, e.full_name, e.image_path
    FROM attendance_logs al
    JOIN employees e ON al.employee_id = e.id
    WHERE DATE(al.timestamp) = :date
    ORDER BY al.timestamp DESC
", ['date' => $date])->fetchAll();

// Prepare the data for the view
$title = 'Attendance Logs';
$view = 'views/attendance/logs.view.php';  // Updated path

require 'views/layout.view.php';