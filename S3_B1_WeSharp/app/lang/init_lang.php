<?php
/**
 * @file init_lang.php
 * Initializes the current language in the session and gets the texts in the right language
 * 
 * @package DE-BUT
 */

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'] === 'en' ? 'en' : 'fr';
    $_SESSION['lang'] = $lang;
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'fr';
}

$lang = $_SESSION['lang'];

require __DIR__ . "/$lang.php";
?>