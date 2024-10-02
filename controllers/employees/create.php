<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

$title = "Add New Employee";
$view = "views/employees/create.view.php";
require "views/layout.view.php";
