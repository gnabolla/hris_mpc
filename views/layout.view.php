<?php
if (!isset($title)) {
    $title = 'My Application';
}

// Get the absolute base path of your application
$basePath = dirname(__DIR__);

// Correctly require the head partial
require $basePath . "/views/partials/head.php";

// If on auth pages, don't include sidebar and nav
if (in_array($view, ['views/login.view.php', 'views/signup.view.php'])) {
    require $basePath . '/' . $view;
} else {
    echo '<div class="wrapper">';
    require $basePath . "/views/partials/side.php";
    echo '<div id="body" class="active">';
    require $basePath . "/views/partials/nav.php";
    echo '<div class="content">';
    echo '<div class="container">';
    echo '<div class="col-md-12 page-header">';
    require $basePath . '/' . $view;
    echo '</div></div></div>';
}

require $basePath . "/views/partials/foot.php";
?>