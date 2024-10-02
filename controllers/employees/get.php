<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    $config = require('config.php');
    $db = new Database($config['database']);

    $employee = $db->query("SELECT * FROM employees WHERE id = :id", ['id' => $id])->fetch();

    if ($employee) {
        header('Content-Type: application/json');
        echo json_encode($employee);
    } else {
        header('HTTP/1.1 404 Not Found');
    }
} else {
    header('HTTP/1.1 400 Bad Request');
}
