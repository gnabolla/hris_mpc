<?php
// controllers/payslips/index.php

session_start();
require_once __DIR__ . '/../../functions.php';  // if you need your helper functions
ensureLoggedIn();
requireRole('employee'); // only employees see their own payslips

$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

// Fetch payslips for the logged-in employee
$employeeId = $_SESSION['employee_id'];

$payslips = $db->query("
    SELECT * 
    FROM payslips
    WHERE employee_id = :emp_id
    ORDER BY period_end DESC
", [
    'emp_id' => $employeeId
])->fetchAll();

$title = "My Payslips";
$view = "views/payslips/index.view.php";  // you'll create this view
require __DIR__ . '/../../views/layout.view.php';
