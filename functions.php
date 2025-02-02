<?php

/**
 * Filters an array using a callback function.
 *
 * @param array $items
 * @param callable $callback
 * @return array
 */
function filter(array $items, callable $callback): array
{
    return array_filter($items, $callback);
}

/**
 * Dump and die for debugging.
 *
 * @param mixed $value
 */
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

/**
 * Get the current URI.
 *
 * @return string
 */
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
function hasRole($role)
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

/**
 * Redirect users who do not have the required role.
 *
 * @param string $role The required role for access.
 */
function requireRole($role)
{
    if (!hasRole($role)) {
        header('HTTP/1.1 403 Forbidden');
        echo "403 Forbidden - You don't have permission to access this page.";
        exit();
    }
}

/**
 * Redirect users who are not logged in.
 * 
 * FIX: Instead of redirecting to "/login" (which would send the user to http://localhost/login),
 * we use the BASE_URL constant so the user is redirected to the correct URL: http://localhost/hris_mpc/login.
 */
function ensureLoggedIn()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }
}

/**
 * Uploads an image file from the specified input.
 *
 * @param string $fileInputName The name attribute of the file input.
 * @param string $uploadDir The directory to which the file should be uploaded.
 * @return string|null The path to the uploaded image (prefixed with a slash) or null if no file was uploaded.
 * @throws Exception If the file type is invalid, too large, or cannot be moved.
 */
function uploadImage($fileInputName, $uploadDir = 'uploads/employees/')
{
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
        $fileName = $_FILES[$fileInputName]['name'];
        $fileSize = $_FILES[$fileInputName]['size'];
        $fileType = $_FILES[$fileInputName]['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedfileExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            if ($fileSize < 2 * 1024 * 1024) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $dest_path = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    return '/' . $dest_path; // Return the path (with a leading slash) for storing in the DB
                } else {
                    throw new Exception('Error moving the uploaded file.');
                }
            } else {
                throw new Exception('Uploaded file is too large. Maximum size is 2MB.');
            }
        } else {
            throw new Exception('Invalid file type. Only JPG, JPEG, and PNG are allowed.');
        }
    }
    return null; // No file uploaded
}
