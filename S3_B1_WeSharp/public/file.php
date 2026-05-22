<?php
/**
 * @file file.php
 * @brief Handles the display of PDF files to download them.
 *
 * This script retrieves and displays a PDF file stored in the application's upload directory.
 * It is triggered when a user clicks on the "Télécharger le fichier" (or "Download the file") button.
 * 
 * Responsibilities:
 *  - Validate the requested file name
 *  - Prevent unauthorized access (directory traversal protection)
 *  - Send the correct Content-Type headers for PDF display
 *  - Return a 404 error if the file does not exist or access is invalid
 *
 * @package DE-BUT
 */

session_start();

if ($page != 'login' && !isset($_SESSION['compte'])) {
    header("Location: login.php");
    exit;
}

$uploadsDir = __DIR__ . '/../app/uploads/';
$file = basename($_GET['name'] ?? '');

$path = realpath($uploadsDir . $file);

if ($path && str_starts_with($path, realpath($uploadsDir)) && file_exists($path)) {
    header('Content-Type: application/pdf');
    readfile($path);
    die;
} else {
    http_response_code(404);
    echo "Fichier introuvable.";
}