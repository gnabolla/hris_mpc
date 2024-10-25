<?php
// file_content.php - Separate file for handling AJAX requests
if (isset($_POST['action']) && $_POST['action'] === 'getContent') {
    $file = $_POST['file'];
    // Basic security check
    if (strpos($file, '..') !== false) {
        die('Invalid file path');
    }
    
    // Return raw content for code display
    $content = file_get_contents($file);
    header('Content-Type: text/plain');
    echo $content;
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Browser</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial; margin: 20px; }
        .file-tree { margin-left: 20px; }
        .folder { 
            cursor: pointer; 
            color: #d4ac0d;
            margin: 5px 0;
        }
        .file { 
            cursor: pointer; 
            color: #666;
            margin: 5px 0;
        }
        .file:hover, .folder:hover { 
            background: #f0f0f0; 
        }
        .content {
            display: none;
            margin-left: 20px;
            padding: 10px;
            background: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 4px;
            white-space: pre;
            font-family: monospace;
            margin-top: 5px;
        }
        .icon { margin-right: 5px; }
        pre { margin: 0; }
        /* Hide nested file-tree by default */
        .folder.closed > .file-tree {
            display: none;
        }
    </style>
</head>
<body>

<div id="file-browser">
    <?php
    function listFiles($dir) {
        $files = scandir($dir);
        
        echo "<div class='file-tree'>";
        foreach($files as $file) {
            if($file != "." && $file != "..") {
                $path = $dir . '/' . $file;
                if(is_dir($path)) {
                    echo "<div class='folder closed'>"; // Add closed class by default
                    echo "<div class='folder-header' onclick='toggleFolder(event, this)'>";
                    echo "<i class='fas fa-folder icon'></i>" . htmlspecialchars($file);
                    echo "</div>";
                    listFiles($path);
                    echo "</div>";
                } else {
                    echo "<div class='file' onclick='loadContent(event, \"" . htmlspecialchars($path, ENT_QUOTES) . "\", this)'>";
                    echo "<i class='fas fa-file icon'></i>" . htmlspecialchars($file);
                    echo "<pre class='content'><code class='language-" . pathinfo($file, PATHINFO_EXTENSION) . "'></code></pre>";
                    echo "</div>";
                }
            }
        }
        echo "</div>";
    }

    listFiles('.');  // Start from current directory
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script>
function toggleFolder(event, element) {
    event.stopPropagation();
    
    const folderContainer = element.parentElement;
    folderContainer.classList.toggle('closed');
    
    const icon = element.querySelector('.fa-folder, .fa-folder-open');
    if (icon) {
        icon.classList.toggle('fa-folder');
        icon.classList.toggle('fa-folder-open');
    }
}

function loadContent(event, path, element) {
    event.stopPropagation();
    
    let contentElement = element.querySelector('.content');
    let codeElement = element.querySelector('code');
    
    if (contentElement.style.display === 'block') {
        contentElement.style.display = 'none';
        return;
    }
    
    if (!codeElement.textContent) {
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=getContent&file=${encodeURIComponent(path)}`
        })
        .then(response => response.text())
        .then(content => {
            codeElement.textContent = content;
            Prism.highlightElement(codeElement);
            contentElement.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
            contentElement.textContent = 'Error loading file content';
            contentElement.style.display = 'block';
        });
    } else {
        contentElement.style.display = 'block';
    }
}
</script>
</body>
</html>