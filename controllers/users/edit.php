<?php
session_start();

ensureLoggedIn();
requireRole('admin');

$config = require('config.php');
$db = new Database($config['database']);

$id = $_GET['id'] ?? null;

if (!$id) {
    abort(400); // Bad Request
}

// Fetch user details
$user = $db->query("
    SELECT u.*, e.employee_id AS employee_code, e.full_name AS employee_full_name
    FROM users u
    LEFT JOIN employees e ON u.employee_id = e.id
    WHERE u.id = :id
", ['id' => $id])->fetch();

if (!$user) {
    abort(404); // Not Found
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'employee';
    $status = $_POST['status'] ?? 'Active';
    $password = $_POST['password'] ?? '';

    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }
    if (!in_array($role, ['admin', 'employee'])) {
        $errors[] = 'Invalid role selected.';
    }
    if (!in_array($status, ['Active', 'Disabled'])) {
        $errors[] = 'Invalid status selected.';
    }

    // Check if email is unique
    $existingUser = $db->query("
        SELECT id FROM users WHERE email = :email AND id != :id
    ", ['email' => $email, 'id' => $id])->fetch();
    if ($existingUser) {
        $errors[] = 'This email is already registered.';
    }

    if (empty($errors)) {
        $updateData = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'status' => $status
        ];

        if (!empty($password)) {
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateData['password'] = $hashedPassword;
        }

        $db->update('users', $updateData, ['id' => $id]);

        $_SESSION['success'] = 'User updated successfully.';
        header('Location: /users');
        exit();
    }
}

$title = 'Edit User';
$view = 'views/users/edit.view.php';
require 'views/layout.view.php';
?>
