<?php
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$routes = [
    "/" => "controllers/index.php",
    "/login" => "controllers/login.php",
    "/signup" => "controllers/signup.php",
    "/logout" => "controllers/logout.php",
    "/employees" => "controllers/employees/index.php",
    "/employees/store" => "controllers/employees/store.php",
    "/employees/update" => "controllers/employees/update.php",
    "/employees/delete" => "controllers/employees/delete.php",
    "/employees/get" => "controllers/employees/get.php",
    "/employees/profile" => "controllers/index.php",
    "/employees/update_profile" => "controllers/employees/update_profile.php", // New Route
    "/files" => "files.php",
    "/allfile" => "allfile.php",
    // Add other routes as needed
];


function abort($code = 404)
{
    http_response_code($code);
    $title = "{$code} Error";
    $view = "views/{$code}.php";
    require "views/layout.view.php";
    exit();
}

function routeToController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        $controller = $routes[$uri];
        if (file_exists($controller)) {
            require $controller;
        } else {
            abort(500); // Internal Server Error
        }
    } else {
        abort(404);
    }
}

routeToController($uri, $routes);
