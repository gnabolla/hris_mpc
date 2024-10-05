<?php
session_start();

ensureLoggedIn();
requireRole('admin');

$config = require('config.php');
$db = new Database($config['database']);

$search = $_GET['search'] ?? '';

if ($search) {
    $leaves = $db->query("
        SELECT lr.*, u.name AS employee_name, e.full_name
        FROM leave_requests lr
        JOIN users u ON lr.employee_id = u.employee_id
        JOIN employees e ON lr.employee_id = e.id
        WHERE e.full_name LIKE :search OR lr.employee_id LIKE :search
        ORDER BY lr.created_at DESC
    ", [
        'search' => '%' . $search . '%'
    ])->fetchAll();
} else {
    $leaves = $db->query("
        SELECT lr.*, u.name AS employee_name, e.full_name
        FROM leave_requests lr
        JOIN users u ON lr.employee_id = u.employee_id
        JOIN employees e ON lr.employee_id = e.id
        ORDER BY lr.created_at DESC
    ")->fetchAll();
}

$title = "Manage Leave Requests";
$view = "views/leaves/manage.view.php";
require "views/layout.view.php";
?>
