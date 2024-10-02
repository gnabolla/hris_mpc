<?php

function filter(array $items, callable $callback): array
{
    return array_filter($items, $callback);
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function getURI(): string
{
    return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
}

/**
 * Check if the current user has the specified role.
 *
 * @param string $role The role to check against (e.g., 'admin', 'employee').
 * @return bool True if the user has the role, false otherwise.
 */
function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

/**
 * Redirect users who do not have the required role.
 *
 * @param string $role The required role for access.
 */
function requireRole($role) {
    if (!hasRole($role)) {
        header('HTTP/1.1 403 Forbidden');
        echo "403 Forbidden - You don't have permission to access this page.";
        exit();
    }
}

/**
 * Redirect users who are not logged in.
 */
function ensureLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
}
