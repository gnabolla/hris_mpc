<?php
// File: controllers/payroll/index.php

session_start();
require_once __DIR__ . '/../../functions.php';
ensureLoggedIn();
requireRole('admin');

$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

$title = "Payroll Management";

// Fetch the last 10 payslips for display (you can customize)
$payslips = $db->query("
    SELECT p.*, e.full_name, e.pay_type
    FROM payslips p
    JOIN employees e ON p.employee_id = e.id
    ORDER BY p.created_at DESC
    LIMIT 10
")->fetchAll();

// We’ll use a separate view to show the form + the table
$view = "views/payroll/index.view.php";
require __DIR__ . '/../../views/layout.view.php';
