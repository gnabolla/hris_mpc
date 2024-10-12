<?php
session_start();

ensureLoggedIn();
requireRole('employee');

$config = require('config.php');
$db = new Database($config['database']);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $contact_information = trim($_POST['contact_information'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $bank_account_details = trim($_POST['bank_account_details'] ?? '');
    $emergency_contact = trim($_POST['emergency_contact'] ?? '');

    if (empty($full_name)) {
        $errors[] = 'Full Name is required.';
    }
    // Other validation...

    if (empty($errors)) {
        $data = [
            'full_name' => $full_name,
            'contact_information' => $contact_information,
            'position' => $position,
            'department' => $department,
            'bank_account_details' => $bank_account_details,
            'emergency_contact' => $emergency_contact,
        ];

        // Handle Image Upload
        try {
            $imagePath = uploadImage('image');
            if ($imagePath) {
                $data['image_path'] = $imagePath;

                // Delete old image if it exists
                $oldImage = $db->query("SELECT image_path FROM employees WHERE id = :id", ['id' => $_SESSION['employee_id']])->fetch()['image_path'];
                if ($oldImage && file_exists(__DIR__ . '/../..' . $oldImage)) {
                    unlink(__DIR__ . '/../..' . $oldImage);
                }
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (empty($errors)) {
            // Build the SET part of the SQL query
            $setPart = '';
            foreach ($data as $column => $value) {
                $setPart .= "{$column} = :{$column}, ";
            }
            $setPart = rtrim($setPart, ', ');

            $params = $data;
            $params['id'] = $_SESSION['employee_id'];

            $sql = "UPDATE employees SET {$setPart} WHERE id = :id";
            $db->query($sql, $params);

            header('Location: /employees/profile');
            exit();
        }
    }
}

// Fetch current employee data
$employee = $db->query("SELECT * FROM employees WHERE id = :id", ['id' => $_SESSION['employee_id']])->fetch();

$title = 'Update Profile';
$view = "views/employees/update_profile.view.php";
require "views/layout.view.php";
?>