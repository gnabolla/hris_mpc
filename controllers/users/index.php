<?php
session_start();

ensureLoggedIn();
requireRole('admin');

$config = require('config.php');
$db = new Database($config['database']);

// Fetch all users along with their employee IDs and full names
$users = $db->query("
    SELECT u.*, e.employee_id AS employee_code, e.full_name AS employee_full_name
    FROM users u
    LEFT JOIN employees e ON u.employee_id = e.id
    ORDER BY u.created_at DESC
")->fetchAll();

$title = 'User Management';
$view = 'views/users/index.view.php';
require 'views/layout.view.php';
?>
