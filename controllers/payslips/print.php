<?php
// File: controllers/payslips/print.php
session_start();
require_once __DIR__ . '/../../functions.php';
ensureLoggedIn();
requireRole('employee'); // only employees can see this route

$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

// We expect a GET param like /payslips/print?id=XXX
$payslipId = $_GET['id'] ?? null;
if (!$payslipId) {
    // No ID provided, or invalid -> redirect or show error
    header('Location: /payslips');
    exit();
}

// Fetch the payslip from DB
$payslip = $db->query("
    SELECT p.*, e.full_name, e.employee_id
    FROM payslips p
    JOIN employees e ON p.employee_id = e.id
    WHERE p.id = :id
", ['id' => $payslipId])->fetch();
if (!$payslip) {
    // Payslip does not exist
    $_SESSION['error'] = "Payslip not found.";
    header('Location: /payslips');
    exit();
}


$title = "Payslip";
$view = "views/payslips/print.view.php";

// Instead of the normal layout
$basePath = dirname(__DIR__, 2); // adjust as needed
require $basePath . "/views/layout.print.view.php";