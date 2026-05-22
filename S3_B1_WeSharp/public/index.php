<?php
/**
 * @file index.php
 * @brief Main entry point of the DE-BUT web application.
 * 
 * This file:
 * - Starts the PHP session
 * - Loads dependencies and configuration files
 * - Initializes the database connection
 * - Routes users to the correct page (controller/view)
 * 
 * @package DE-BUT
 */

session_start();

require_once __DIR__ . '/../app/lang/init_lang.php';


// Load dependencies
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/views/layout/header.php';
require_once __DIR__ . '/../app/views/layout/footer.php';
require_once __DIR__ . '/../app/config/constants.php';
require_once __DIR__ . '/../app/Controllers/QcmController.php';

use App\Database\DatabaseConnection;
use App\DAO\CoursDAO;
use App\DAO\QcmDAO;
use App\DAO\MatieresDAO;
use App\DAO\UserCompteDAO;
use App\Controllers\Factory\ControllerFactory;
use App\DAO\EtudierCoursDAO;


// Creates the database connection
$db = (new DatabaseConnection())->getDb();

// Creates the instances of the DAO
$coursDao = new CoursDAO($db);
$qcmDao = new QcmDAO($db);
$matieresDao = new MatieresDAO($db);
$userCompteDao = new UserCompteDAO($db);
$etudierCoursDao = new EtudierCoursDAO($db); 

// Language switch handling
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];

    // Sécuriser les valeurs possibles
    if (in_array($lang, ['fr', 'en'])) {
        $_SESSION['lang'] = $lang;
    }
}

// Gets the requested page (default : home)
$page = $_GET['page'] ?? 'accueil';

// Redirection to the login page 
if ($page != 'login' && !isset($_SESSION['compte'])) {
    header("Location: login.php");
    exit;
}



// Displays the header
echo GenerateHeader($page);



#region Controller Factory

// Ask factory which controller/action to use
[$controller, $method] = ControllerFactory::create($page, $coursDao, $qcmDao, $matieresDao, $userCompteDao, $etudierCoursDao );

// If no controller, load the view directly
if ($controller === null) {
    require __DIR__ . '/../app/views/pages/accueil.php';
} else {
    // Error message if the method does not exist
    if (!method_exists($controller, $method)) 
    {
        die("Unknown method : $method");
    }

    if ($page === 'admin' && $_SESSION['compte']['role'] !== 'admin') {
        header("Location: index.php?page=accueil");
        exit;
    }

    // Handle page-specific parameters
    if ($page === 'cours_lecture' || $page === 'qcm_start' || $page === 'cours_edit' ) 
    {
        $controller->$method($_GET['id'] ?? null);
    } else {
        $controller->$method();
    }
}
#endregion



// Displays the footer
echo GenerateFooter();