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

// Get features by scanning controllers and views directories
function detectFeatures()
{
    $features = [];
    $featureDirs = ['controllers', 'views'];

    foreach ($featureDirs as $dir) {
        if (is_dir($dir)) {
            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item != "." && $item != ".." && is_dir("$dir/$item") && !in_array($item, ['partials'])) {
                    $features[$item] = true;
                }
            }
        }
    }

    return array_keys($features);
}

$detectedFeatures = detectFeatures();
?>

<!DOCTYPE html>
<html>

<head>
    <title>File Browser</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        .file-tree {
            margin-left: 20px;
        }

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

        .file:hover,
        .folder:hover {
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

        .icon {
            margin-right: 5px;
        }

        pre {
            margin: 0;
        }

        .folder.closed>.file-tree {
            display: none;
        }

        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-button:hover {
            background: #45a049;
        }

        .feature-button {
            background: #2196F3;
        }

        .feature-button:hover {
            background: #1976D2;
        }

        .core-file {
            background-color: #fff3e0;
        }

        .feature-file {
            background-color: #e3f2fd;
        }

        /* Add visual indicator for active buttons */
        .action-button.active {
            background: #333;
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
        }

        .feature-button.active {
            background: #1565C0;
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
        }
    </style>
</head>

<body>

    <div class="action-buttons">
        <button id="core-button" class="action-button" onclick="showCoreFiles()">
            <i class="fas fa-code"></i> Show Core Files
        </button>

        <?php foreach ($detectedFeatures as $feature): ?>
            <button id="<?php echo htmlspecialchars($feature); ?>-button" 
                    class="action-button feature-button" 
                    onclick="showFeatureFiles('<?php echo htmlspecialchars($feature); ?>')">
                <i class="fas fa-folder-open"></i> Show <?php echo ucfirst(htmlspecialchars($feature)); ?> Files
            </button>
        <?php endforeach; ?>
    </div>

    <div id="file-browser">
        <?php
        function listFiles($dir)
        {
            $files = scandir($dir);

            echo "<div class='file-tree'>";
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    $path = $dir . '/' . $file;
                    if (is_dir($path)) {
                        echo "<div class='folder closed'>";
                        echo "<div class='folder-header' onclick='toggleFolder(event, this)'>";
                        echo "<i class='fas fa-folder icon'></i>" . htmlspecialchars($file);
                        echo "</div>";
                        listFiles($path);
                        echo "</div>";
                    } else {
                        $isCoreFile = isCoreFile($path);
                        $featureClass = getFeatureClass($path);
                        $classes = ['file'];
                        if ($isCoreFile) $classes[] = 'core-file';
                        if ($featureClass) $classes[] = $featureClass;

                        echo "<div class='" . implode(' ', $classes) . "' " .
                            "data-path='" . htmlspecialchars($path, ENT_QUOTES) . "' " .
                            "data-feature='" . htmlspecialchars(getFeatureName($path), ENT_QUOTES) . "' " .
                            "onclick='loadContent(event, \"" . htmlspecialchars($path, ENT_QUOTES) . "\", this)'>";
                        echo "<i class='fas fa-file icon'></i>" . htmlspecialchars($file);
                        echo "<pre class='content'><code class='language-" . pathinfo($file, PATHINFO_EXTENSION) . "'></code></pre>";
                        echo "</div>";
                    }
                }
            }
            echo "</div>";
        }

        function isCoreFile($path)
        {
            $coreFiles = [
                './Database.php',
                './config.php',
                './functions.php',
                './router.php',
                './index.php',
                './views/partials/foot.php',
                './views/partials/head.php',
                './views/partials/nav.php',
                './views/partials/side.php',
                './views/index.view.php',
                './views/layout.view.php',
            ];

            $normalizedPath = str_replace('\\', '/', './' . ltrim($path, './'));
            return in_array($normalizedPath, $coreFiles);
        }

        function getFeatureClass($path)
        {
            $normalizedPath = str_replace('\\', '/', $path);
            if (preg_match('/(controllers|views)\/([^\/]+)\//', $normalizedPath, $matches)) {
                if ($matches[2] !== 'partials') {
                    return 'feature-file ' . $matches[2] . '-feature';
                }
            }
            return '';
        }

        function getFeatureName($path)
        {
            $normalizedPath = str_replace('\\', '/', $path);
            if (preg_match('/(controllers|views)\/([^\/]+)\//', $normalizedPath, $matches)) {
                if ($matches[2] !== 'partials') {
                    return $matches[2];
                }
            }
            return '';
        }

        listFiles('.');  // Start from current directory
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script>
        // Track the state of each feature group
        const fileGroupStates = {
            core: false,
            features: {}
        };

        function updateButtonStates() {
            // Update core button
            const coreButton = document.getElementById('core-button');
            if (coreButton) {
                coreButton.classList.toggle('active', fileGroupStates.core);
            }

            // Update feature buttons
            Object.entries(fileGroupStates.features).forEach(([feature, isEnabled]) => {
                const featureButton = document.getElementById(`${feature}-button`);
                if (featureButton) {
                    featureButton.classList.toggle('active', isEnabled);
                }
            });
        }

        function showCoreFiles() {
            // Toggle the state
            fileGroupStates.core = !fileGroupStates.core;
            updateFileVisibility();
            updateButtonStates();
        }

        function showFeatureFiles(feature) {
            // Initialize state if it doesn't exist
            if (fileGroupStates.features[feature] === undefined) {
                fileGroupStates.features[feature] = false;
            }

            // Toggle the state
            fileGroupStates.features[feature] = !fileGroupStates.features[feature];
            updateFileVisibility();
            updateButtonStates();
        }

        function updateFileVisibility() {
            // First hide all content
            document.querySelectorAll('.content').forEach(content => {
                content.style.display = 'none';
            });

            // Close all folders
            document.querySelectorAll('.folder').forEach(folder => {
                folder.classList.add('closed');
                const icon = folder.querySelector('.fa-folder, .fa-folder-open');
                if (icon) {
                    icon.classList.remove('fa-folder-open');
                    icon.classList.add('fa-folder');
                }
            });

            // Show core files if enabled
            if (fileGroupStates.core) {
                expandAndShowFiles('.core-file');
            }

            // Show enabled feature files
            Object.entries(fileGroupStates.features).forEach(([feature, isEnabled]) => {
                if (isEnabled) {
                    expandAndShowFiles(`.${feature}-feature`);
                }
            });
        }

        function expandAndShowFiles(selector) {
            // Expand folders containing target files
            document.querySelectorAll(selector).forEach(file => {
                let parent = file.parentElement;
                while (parent && parent.classList.contains('file-tree')) {
                    const folderContainer = parent.parentElement;
                    if (folderContainer && folderContainer.classList.contains('folder')) {
                        folderContainer.classList.remove('closed');
                        const icon = folderContainer.querySelector('.fa-folder, .fa-folder-open');
                        if (icon) {
                            icon.classList.remove('fa-folder');
                            icon.classList.add('fa-folder-open');
                        }
                    }
                    parent = folderContainer ? folderContainer.parentElement : null;
                }
            });

            // Load content for all matching files
            document.querySelectorAll(selector).forEach(file => {
                const path = file.getAttribute('data-path');
                loadContent(new Event('click'), path, file, true);
            });
        }

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

        function loadContent(event, path, element, forceShow = false) {
            event.stopPropagation();

            let contentElement = element.querySelector('.content');
            let codeElement = element.querySelector('code');

            if (contentElement.style.display === 'block' && !forceShow) {
                contentElement.style.display = 'none';
                return;
            }

            if (!codeElement.textContent || forceShow) {
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