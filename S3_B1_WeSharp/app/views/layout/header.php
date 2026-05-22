<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<?php
#region Methods
/** 
 * Generates the HTML header code used on each page
 * Changes the style of the navigation bar based on the name of the current page ($page).
 * 
 * @param string $page The current page
 * @return string The HTML header code
*/
function GenerateHeader(string $page) : string {

    global $t;

    // Current language (default : french)
    $currentLang  = $_SESSION['lang'] ?? 'fr';

    $res = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!-- Window logo -->
            <link rel="shortcut icon" href="./images/debut.png">
            <!-- Window name -->
            <title>' . WEBSITE_NAME . ' - ' . ucfirst(htmlspecialchars($page)) . '</title>

            <!-- Steelsheet -->
            <link rel="stylesheet" href="./styles/style.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap">
            <!-- Icons -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        </head>

        <!-- Body -->
        <body>
        <body>
        <header>
            <div class="navbar-top">
                <a class="brand" href="index.php">
                    <img src="./images/debut.png" alt="Logo du site">' . WEBSITE_NAME . '
                </a>
            <div class="navbar-top">
                <a class="brand" href="index.php">
                    <img src="./images/debut.png" alt="Logo du site">' . WEBSITE_NAME . '
                </a>
                <div class="nav-links">
                    <nav>
                        <a href="index.php" class="'.($page === "accueil" ? "accueil-lien-bleu" : "accueil-lien").'">' . $t['nav_home'] . '</a>
                    </nav>
                    <nav>
                        <a href="./index.php?page=cours" class="'.($page === "cours" || $page === "cours_lecture" ? "cours-lien-bleu" : "cours-lien").'">' . $t['nav_courses'] . '</a>
                    </nav>
                    <nav>
                        <a href="./index.php?page=exercices" class="'.($page === "exercices" ? "exercices-lien-bleu" : "exercices-lien").'">' . $t['nav_exercises'] . '</a>
                    </nav>
                    <nav>
                        <a href="./index.php?page=qcm" class="'.($page === "qcm" || $page === "qcm_questions" || $page === "qcm_result" ? "qcm-lien-bleu" : "qcm-lien").'">' . $t['nav_quiz'] . '</a>
                    </nav>';

                    if (isset($_SESSION["compte"]) && $_SESSION["compte"]["role"] === "admin") {
                        $res .= '<nav>
                            <a href="./index.php?page=admin" class="'.($page === "admin" ? "admin-lien-bleu" : "admin-lien").'">' . $t['nav_admin'] . '</a>
                        </nav>';
                    }

                    $res .= '
                    <nav class="lang-switch">
                        <i class="fa-solid fa-language"></i>
                        <select id="lang-select"
                            onchange="window.location.href=\'index.php?page=' . htmlspecialchars($page) . '&lang=\' + this.value;">
                            <option value="fr"' . ($currentLang === "fr" ? " selected" : "") . '>FR</option>
                            <option value="en"' . ($currentLang === "en" ? " selected" : "") . '>EN</option>
                        </select>
                    </nav>';

                    $res .= '<nav class="logout-nav">';
                    if (isset($_SESSION["compte"])) 
                    {
                        $res .= '<span class="separator"></span><a class="logout-link" href="./index.php?page=logout" onclick="return confirm(\'Voulez-vous vraiment vous déconnecter ?\');">' . $t['nav_logout'] . '</a>';
                    }

                    $res .= '</nav>    
                </div>
            </div>
            
        </header>

        <!-- Alerts -->
        ';
        
        if (!empty($_SESSION["success"]) || !empty($_SESSION["error"])) {
            $res .= '<div class="alert-container">';

            if (!empty($_SESSION["success"])) {
                $res .= '<div class="alert alert-success">' . $_SESSION["success"] . '</div>';
            }

            if (!empty($_SESSION["error"])) {
                $res .= '<div class="alert alert-error">';
                
                if (is_array($_SESSION["error"])) {
                    $res .= '<ul>';
                    foreach ($_SESSION["error"] as $err) {
                        $res .= '<li>' . htmlspecialchars($err) . '</li>';
                    }
                    $res .= '</ul>';
                } else {
                    $res .= htmlspecialchars($_SESSION["error"]);
                }

                $res .= '</div>';
            }

            $res .= '</div>';

            // Clear session messages
            unset($_SESSION["success"]);
            unset($_SESSION["error"]);
        }

        $res .= '
        <main>

        <script src="./js/alerts.js"></script>';

    return $res;
}
#endregion