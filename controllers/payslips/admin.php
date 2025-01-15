<?php
// controllers/payslips/admin.php

session_start();
require_once __DIR__ . '/../../functions.php';
ensureLoggedIn();
requireRole('admin'); // only admin sees payroll for all employees

$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

// Optional: handle a query param for year/month
$year = $_GET['year'] ?? date('Y');
$month = $_GET['month'] ?? date('m');

// Build start/end of month
$startDate = "{$year}-{$month}-01";
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$endDate = "{$year}-{$month}-{$daysInMonth}";

// Fetch payslips for this month
$payroll = $db->query("
    SELECT p.*, e.full_name, e.employee_id
    FROM payslips p
    JOIN employees e ON e.id = p.employee_id
    WHERE p.period_start = :start
      AND p.period_end = :end
    ORDER BY e.full_name
", [
    'start' => $startDate,
    'end'   => $endDate
])->fetchAll();

$title = "Payroll for {$year}-{$month}";
$view = "views/payslips/admin.view.php"; // you'll create this view
require __DIR__ . '/../../views/layout.view.php';
