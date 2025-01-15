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
    "/employees/update_profile" => "controllers/employees/update_profile.php",
    "/leaves/request" => "controllers/leaves/request.php",
    "/leaves/manage" => "controllers/leaves/manage.php",
    "/leaves/approve" => "controllers/leaves/approve.php",
    "/leaves/reject" => "controllers/leaves/reject.php",
    "/leaves/list" => "controllers/leaves/list.php",
    "/users" => "controllers/users/index.php",
    "/users/edit" => "controllers/users/edit.php",
    "/users/delete" => "controllers/users/delete.php",
    "/files" => "files_template.php",
    "/allfile" => "allfile.php",
    "/attendance" => "controllers/attendance/index.php",
    "/attendance/log" => "controllers/attendance/log.php",
    "/attendance/clocked_in" => "controllers/attendance/clocked_in.php",
    "/attendance/logs" => "controllers/attendance/logs.php",
    "/attendance/api" => "controllers/attendance/api.php",

    "/payslips" => "controllers/payslips/index.php",
    "/payslips/print" => "controllers/payslips/print.php",  // NEW for employees

    "/payroll" => "controllers/payroll/index.php",
    "/payroll/generate" => "controllers/payroll/generate.php",
    "/payroll/print" => "controllers/payroll/print.php",    // NEW for admin
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
