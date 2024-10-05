<?php
session_start();

ensureLoggedIn();
requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $config = require('config.php');
        $db = new Database($config['database']);

        // Prevent admin from deleting themselves
        if ($id == $_SESSION['user_id']) {
            // Optionally, set an error message in session
            $_SESSION['error'] = 'You cannot delete your own account.';
            header('Location: /users');
            exit();
        }

        // Fetch the user to ensure they exist
        $user = $db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->fetch();

        if (!$user) {
            $_SESSION['error'] = 'User not found.';
            header('Location: /users');
            exit();
        }

        // Optionally, check if the user has related records that need handling

        // Delete the user
        $db->delete('users', ['id' => $id]);

        $_SESSION['success'] = 'User deleted successfully.';
        header('Location: /users');
        exit();
    }
}

abort(400); // Bad Request
?>
