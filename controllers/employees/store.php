<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = require('config.php');
    $db = new Database($config['database']);

    // Collect form data
    $data = [
        'full_name' => $_POST['full_name'],
        'employee_id' => $_POST['employee_id'],
        'rfid' => !empty($_POST['rfid']) ? $_POST['rfid'] : null,
        'date_of_birth' => $_POST['date_of_birth'],
        'contact_information' => $_POST['contact_information'],
        'position' => $_POST['position'],
        'department' => $_POST['department'],
        'date_of_hire' => $_POST['date_of_hire'],
        'employment_status' => $_POST['employment_status'],
        'salary' => $_POST['salary'],
        'bank_account_details' => $_POST['bank_account_details'],
        'emergency_contact' => $_POST['emergency_contact'],
        'image_path' => null, // Initialize image_path to null
    ];

    // Handle Image Upload
    try {
        $imagePath = uploadImage('image');
        if ($imagePath) {
            $data['image_path'] = $imagePath;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /employees');
        exit();
    }
    // Insert the employee into the database
    try {

        $db->query("INSERT INTO employees (full_name, employee_id, rfid, date_of_birth, contact_information, position, department, date_of_hire, employment_status, salary, bank_account_details, emergency_contact, image_path)
VALUES (:full_name, :employee_id, :rfid, :date_of_birth, :contact_information, :position, :department, :date_of_hire, :employment_status, :salary, :bank_account_details, :emergency_contact, :image_path)", $data);

        $_SESSION['success'] = 'Employee added successfully.';
        header('Location: /employees');
        dd("ahaha");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error adding employee: ' . $e->getMessage();
        header('Location: /employees');
        exit();
    }
}
