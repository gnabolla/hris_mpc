<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    $config = require('config.php');
    $db = new Database($config['database']);

    $employee = $db->query("SELECT * FROM employees WHERE id = :id", ['id' => $id])->fetch();

    if (!$employee) {
        header('Location: /employees');
        exit();
    }
} else {
    header('Location: /employees');
    exit();
}

$title = "Edit Employee";
$view = "views/employees/edit.view.php";
require "views/layout.view.php";
