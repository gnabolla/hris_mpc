<?php
session_start();

ensureLoggedIn();

$config = require('config.php');
$db = new Database($config['database']);

if (hasRole('admin')) {
    $title = "Dashboard";
    $view = "views/index.view.php";
} elseif (hasRole('employee')) {
    // Fetch the logged-in employee's data
    $employee = $db->query("SELECT * FROM employees WHERE id = :id", ['id' => $_SESSION['employee_id']])->fetch();
    $title = "My Dashboard";
    $view = "views/employees/profile.view.php";
} else {
    abort(403);
}

require "views/layout.view.php";
?>
