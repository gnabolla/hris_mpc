<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $config = require('config.php');
    $db = new Database($config['database']);

    // Collect form data
    $data = [
        'full_name'            => $_POST['full_name'],
        'employee_id'          => $_POST['employee_id'],
        'date_of_birth'        => $_POST['date_of_birth'],
        'contact_information'  => $_POST['contact_information'],
        'position'             => $_POST['position'],
        'department'           => $_POST['department'],
        'date_of_hire'         => $_POST['date_of_hire'],
        'employment_status'    => $_POST['employment_status'],

        // NEW: Pay Type (ensures we capture changes to the pay_type field)
        'pay_type'             => $_POST['pay_type'], // 'Monthly', 'Daily', or 'Hourly'

        'salary'               => $_POST['salary'],
        'bank_account_details' => $_POST['bank_account_details'],
        'emergency_contact'    => $_POST['emergency_contact'],
        'rfid'                 => !empty($_POST['rfid']) ? $_POST['rfid'] : null,
    ];

    // Handle Image Upload
    try {
        $imagePath = uploadImage('image');
        if ($imagePath) {
            $data['image_path'] = $imagePath;

            // Optionally, delete the old image if it exists
            $oldImage = $db->query("SELECT image_path FROM employees WHERE id = :id", [
                'id' => $id
            ])->fetch()['image_path'];

            if ($oldImage && file_exists(__DIR__ . '/../..' . $oldImage)) {
                unlink(__DIR__ . '/../..' . $oldImage);
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: /employees');
        exit();
    }

    // Update the employee in the database
    try {
        // Build the SET part of the SQL dynamically
        $setPart = '';
        foreach ($data as $column => $value) {
            $setPart .= "{$column} = :{$column}, ";
        }
        // Remove trailing comma
        $setPart = rtrim($setPart, ', ');

        // Bind parameters
        $params = $data;
        $params['id'] = $id;

        // Execute update
        $sql = "UPDATE employees SET {$setPart} WHERE id = :id";
        $db->query($sql, $params);

        $_SESSION['success'] = 'Employee updated successfully.';
        header('Location: /employees');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error updating employee: ' . $e->getMessage();
        header('Location: /employees');
        exit();
    }
}
?>
