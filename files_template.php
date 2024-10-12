<?php
// Array of file paths relative to the script's location
$files = [
    'hris_db.sql',
    'Database.php',
    'config.php',
    'functions.php',
    'router.php',
    'index.php',
    'views/partials/foot.php',
    'views/partials/head.php',
    'views/partials/nav.php',
    'views/partials/side.php',
    'views/index.view.php',
    'views/layout.view.php',
    'controllers/index.php',
];

// Function to safely get the absolute path
function getAbsolutePath($relativePath) {
    return realpath(__DIR__ . DIRECTORY_SEPARATOR . $relativePath);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Project Files Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .file-container {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .file-container h2 {
            margin-top: 0;
            color: #333;
        }
        .code-block {
            background-color: #272822;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
        }
        .not-found {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Project Files Overview</h1>
    <?php foreach ($files as $file): ?>
        <div class="file-container">
            <h2>File: <?php echo htmlspecialchars($file); ?></h2>
            <?php
                $absolutePath = getAbsolutePath($file);
                if ($absolutePath && file_exists($absolutePath)) {
                    // Get the file extension to handle different types if needed
                    $extension = pathinfo($absolutePath, PATHINFO_EXTENSION);
                    
                    // Read the file content
                    $content = file_get_contents($absolutePath);
                    
                    // Optionally, you can add syntax highlighting here
                    // For simplicity, we'll just display the code in a styled <pre>
                    echo '<pre class="code-block">' . htmlspecialchars($content) . '</pre>';
                    
                    // Alternatively, use PHP's highlight_string for PHP files
                    /*
                    if ($extension === 'php') {
                        highlight_string($content);
                    } else {
                        echo '<pre>' . htmlspecialchars($content) . '</pre>';
                    }
                    */
                } else {
                    echo '<p class="not-found">File not found.</p>';
                }
            ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
