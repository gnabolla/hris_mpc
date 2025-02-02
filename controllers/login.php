<?php
session_start();

$config = require('config.php');
$db = new Database($config['database']);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        $user = $db->query('SELECT * FROM users WHERE email = :email', ['email' => $email])->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['employee_id'] = $user['employee_id'];

            // Redirect using BASE_URL so the user goes to http://localhost/hris_mpc/ not http://localhost/
            header('Location: ' . BASE_URL . '/');
            exit();
        } else {
            $errors[] = 'Email or password is incorrect.';
        }
    }
}

$title = 'Login';
require "views/login.view.php";
