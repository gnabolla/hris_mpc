<?php
session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page using BASE_URL
header('Location: ' . BASE_URL . '/login');
exit();
