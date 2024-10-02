<?php
session_start();

ensureLoggedIn();
requireRole('employee');

$config = require('config.php');
$db = new Database($config['database']);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $contact_information = trim($_POST['contact_information'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $bank_account_details = trim($_POST['bank_account_details'] ?? '');
    $emergency_contact = trim($_POST['emergency_contact'] ?? '');

    if (empty($full_name)) {
        $errors[] = 'Full Name is required.';
    }
    if (empty($contact_information)) {
        $errors[] = 'Contact Information is required.';
    }
    if (empty($position)) {
        $errors[] = 'Position is required.';
    }
    if (empty($department)) {
        $errors[] = 'Department is required.';
    }
    if (empty($bank_account_details)) {
        $errors[] = 'Bank Account Details are required.';
    }
    if (empty($emergency_contact)) {
        $errors[] = 'Emergency Contact is required.';
    }

    if (empty($errors)) {
        $db->update('employees', [
            'full_name' => $full_name,
            'contact_information' => $contact_information,
            'position' => $position,
            'department' => $department,
            'bank_account_details' => $bank_account_details,
            'emergency_contact' => $emergency_contact
        ], ['id' => $_SESSION['employee_id']]);

        header('Location: /employees/profile');
        exit();
    }
}

// Fetch current employee data
$employee = $db->query("SELECT * FROM employees WHERE id = :id", ['id' => $_SESSION['employee_id']])->fetch();

$title = 'Update Profile';
$view = "views/employees/update_profile.view.php";
require "views/layout.view.php";
?>
