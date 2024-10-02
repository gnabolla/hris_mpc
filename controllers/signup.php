<?php
$config = require('config.php');
$db = new Database($config['database']);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = isset($_POST['confirm']);
    $employee_id_input = trim($_POST['employee_id'] ?? '');

    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }
    if (!$confirm) {
        $errors[] = 'You must agree to the terms and policy.';
    }
    if (empty($employee_id_input)) {
        $errors[] = 'Employee ID is required.';
    }

    // Check if employee_id exists in employees table
    if (!empty($employee_id_input)) {
        $employee = $db->query('SELECT id FROM employees WHERE employee_id = :employee_id', ['employee_id' => $employee_id_input])->fetch();
        if (!$employee) {
            $errors[] = 'Invalid Employee ID.';
        } else {
            // Check if employee_id is already linked to a user
            $existingUser = $db->query('SELECT id FROM users WHERE employee_id = :employee_id', ['employee_id' => $employee['id']])->fetch();
            if ($existingUser) {
                $errors[] = 'This Employee ID is already registered.';
            }
        }
    }

    // Check if email already exists
    if (!empty($email)) {
        $existingEmail = $db->query('SELECT id FROM users WHERE email = :email', ['email' => $email])->fetch();
        if ($existingEmail) {
            $errors[] = 'Email is already registered.';
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $db->query(
            'INSERT INTO users (name, email, password, role, employee_id) VALUES (:name, :email, :password, :role, :employee_id)',
            [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => 'employee',
                'employee_id' => $employee['id']
            ]
        );

        header('Location: /login');
        exit();
    }
}

$title = 'Sign Up';
require "views/signup.view.php";
?>
