<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$config = require('config.php');
$db = new Database($config['database']);

$search = $_GET['search'] ?? '';

if ($search) {
    $employees = $db->query("SELECT * FROM employees WHERE full_name LIKE :search OR employee_id LIKE :search OR department LIKE :search", [
        'search' => '%' . $search . '%'
    ])->fetchAll();
} else {
    $employees = $db->query("SELECT * FROM employees")->fetchAll();
}

$title = "Employee Management";
$view = "views/employees/index.view.php";
require "views/layout.view.php";
