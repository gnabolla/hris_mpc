<?php
// File: controllers/payroll/print.php
session_start();
require_once __DIR__ . '/../../functions.php';
ensureLoggedIn();
requireRole('admin'); // only admin can see other people's payslips

$config = require(__DIR__ . '/../../config.php');
$db = new Database($config['database']);

// We expect /payroll/print?id=XXX
$payslipId = $_GET['id'] ?? null;
if (!$payslipId) {
    header('Location: /payroll');
    exit();
}

// Fetch the payslip
$payslip = $db->query("
    SELECT p.*, e.full_name, e.employee_id
    FROM payslips p
    JOIN employees e ON p.employee_id = e.id
    WHERE p.id = :id
", ['id' => $payslipId])->fetch();

if (!$payslip) {
    $_SESSION['error'] = "Payslip not found.";
    header('Location: /payroll');
    exit();
}

// We'll store it in a variable the view can read
// Typically, you'd do something like:
$title = "Print Payslip";

// In the view, we expect $payslip to be available
// So we can do:
$view = "views/payroll/print.view.php";

// The minimal layout:
$basePath = dirname(__DIR__, 2);
require $basePath . "/views/layout.print.view.php";
