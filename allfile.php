<?php
// Function to recursively scan a directory and list all files, excluding specific directories and files
function listFilesAndContents($dir, $excludeDirs = [], $excludeFiles = []) {
    // Open the directory
    $items = scandir($dir);

    // Initialize an array to hold the results
    $files = [];

    foreach ($items as $item) {
        // Skip the special directories '.' and '..'
        if ($item == '.' || $item == '..') {
            continue;
        }

        // Construct the full path
        $path = $dir . DIRECTORY_SEPARATOR . $item;

        // If the item is a directory and not in the excluded directories list
        if (is_dir($path)) {
            if (!in_array($item, $excludeDirs)) {
                $files = array_merge($files, listFilesAndContents($path, $excludeDirs, $excludeFiles));
            }
        } else {
            // Skip excluded files
            if (!in_array(basename($path), $excludeFiles)) {
                // Add file path and content to the array
                $files[] = [
                    'path' => $path,
                    'content' => file_get_contents($path)
                ];
            }
        }
    }

    return $files;
}

// Directory to start from
$baseDir = __DIR__;

// Directories to exclude
$excludeDirs = ['assets']; // Add other directories to exclude if needed

// Files to exclude
$excludeFiles = ['files.php']; // Add other files to exclude if needed

// Get the list of files and their contents, excluding specified directories and files
$files = listFilesAndContents($baseDir, $excludeDirs, $excludeFiles);

// HTML header
echo "<html><head><title>File List</title></head><body>";
echo "<h1>File List and Contents</h1>";

// Display the file paths and contents
foreach ($files as $file) {
    echo "<h2>File: " . htmlspecialchars($file['path']) . "</h2>";
    echo "<pre>" . htmlspecialchars($file['content']) . "</pre>";
}

// HTML footer
echo "</body></html>";
?>
