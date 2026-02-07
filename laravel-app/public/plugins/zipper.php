<?php
// URL of the zip file
$zipFileUrl = 'https://khaki-jay-142239.hostingersite.com/ecommerce/laravel-app/public/plugins.zip'; // Update with the actual URL to your zip file

// Local path to save the downloaded zip file
$zipFilePath = 'local/path/to/downloaded-file.zip'; // Update with the local path where you want to save the zip file

// Directory where you want to extract the files
$extractToPath = 'local/path/to/extract/'; // Update with the local extraction directory

// Ensure the extract directory exists
if (!is_dir($extractToPath)) {
    mkdir($extractToPath, 0777, true);
}

// Download the zip file from the URL
file_put_contents($zipFilePath, file_get_contents($zipFileUrl));

// Initialize ZipArchive
$zip = new ZipArchive;

// Try to open the zip file
if ($zip->open($zipFilePath) === TRUE) {
    // Extract the zip file to the specified directory
    $zip->extractTo($extractToPath);
    $zip->close();
    echo 'Extraction successful!';
    
    // Optionally, delete the downloaded zip file
    unlink($zipFilePath);
} else {
    echo 'Failed to open the zip file!';
}
?>
