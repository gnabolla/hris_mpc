<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $config = require('config.php');
    $db = new Database($config['database']);

    $db->delete('employees', ['id' => $id]);

    header('Location: /employees');
    exit();
}
