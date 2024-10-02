<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = require('config.php');
    $db = new Database($config['database']);

    $data = [
        'full_name' => $_POST['full_name'],
        'employee_id' => $_POST['employee_id'],
        'date_of_birth' => $_POST['date_of_birth'],
        'contact_information' => $_POST['contact_information'],
        'position' => $_POST['position'],
        'department' => $_POST['department'],
        'date_of_hire' => $_POST['date_of_hire'],
        'employment_status' => $_POST['employment_status'],
        'salary' => $_POST['salary'],
        'bank_account_details' => $_POST['bank_account_details'],
        'emergency_contact' => $_POST['emergency_contact'],
    ];

    $db->insert('employees', $data);

    header('Location: /employees');
    exit();
}
