<?php
#region Logic
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/constants.php';

use App\Database\DatabaseConnection;
use App\DAO\UserCompteDAO;

// Gets the token from the URL
$token = $_GET['token'] ?? null;

if (!$token) {
    render_invalid_link();
    exit;
}

// Gets the DAO
$db = (new DatabaseConnection())->getDb();
$userCompteDao = new UserCompteDAO($db);

// Checks if the account linked to the token exists
$compte = $userCompteDao->findByToken($token);

if (!$compte) {
    render_invalid_link();
    exit;
}

// Activates the account if the form was sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = $_POST['password'] ?? '';

    // Security pattern for the password
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-\[\]{}:;\\|,.<>\/?]).{8,}$/";

    if (!preg_match($pattern, $password)) {
        render_form("Votre mot de passe ne respecte pas les critères requis.");
        exit;
    }

    // Uses a secured hashing algorithm
    $hash = password_hash($password, PASSWORD_ARGON2ID);

    if ($userCompteDao->activateAccount($token, $hash)) {
        render_success();
    } else {
        render_error();
    }

    exit;
}

// Display default form
render_form();
#endregion


#region Methods
function render_invalid_link() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Lien invalide</title>
        <link rel="stylesheet" href="./styles/style.css">
        <!-- Window logo -->
        <link rel="shortcut icon" href="./images/debut.png">
    </head>
    <body class="activation-error-body">
        <p class="activation-error-message">Lien d'activation invalide ou expiré.</p>
    </body>
    </html>
    <?php
}

function render_success() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Compte activé</title>
        <link rel="stylesheet" href="./styles/style.css">
        <!-- Window logo -->
        <link rel="shortcut icon" href="./images/debut.png">
    </head>
    <body>

    <div class="page-activation">
        <div class="activation-block">
            <div class="activation-wrapper">
                <div class="activation-title">
                    <img src="./images/debut.png" alt="Logo du site">
                    <h1 class="subtitle-activation">Compte activé</h1>
                </div>
                <p class="message-activate">Votre compte est activé. Vous pouvez maintenant vous connecter.</p>
                <a href="index.php" class="btn-activation-submit btn-activation-link">Se connecter</a>
            </div>
        </div>
    </div>

    </body>
    </html>
    <?php
}

function render_error() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Erreur</title>
        <link rel="stylesheet" href="./styles/style.css">
        <!-- Window logo -->
        <link rel="shortcut icon" href="./images/debut.png">
    </head>
    <body class="activation-error-body">
        <p class="activation-error-message">Une erreur est survenue lors de l'activation.</p>
    </body>
    </html>
    <?php
}

function render_form(string $error = null) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Activation du compte</title>
        <link rel="stylesheet" href="./styles/style.css">
        <!-- Window logo -->
        <link rel="shortcut icon" href="./images/debut.png">
    </head>
    <body>

    <?php if ($error): ?>
        <div class="alert-container">
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        </div>
    <?php endif; ?>

    <div class="page-activation">
        <div class="activation-block">
            <div class="activation-wrapper">

                <div class="activation-title">
                    <img src="./images/debut.png" alt="Logo du site">
                    <h1 class="subtitle-activation">Activation de votre compte</h1>
                </div>

                <form action="" method="POST" class="activation-form">
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe :</label>
                        <input type="password" id="password" name="password"
                            required
                            placeholder="Mot de passe"
                            minlength="8"
                            maxlength="60"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-\[\]{}:;\\|,.<>\/?]).{8,}$"
                        >
                    </div>

                    <div class="password-rules">
                        Votre mot de passe doit contenir :
                        <ul>
                            <li>au moins <strong>8 caractères</strong></li>
                            <li>au moins <strong>1 lettre majuscule</strong></li>
                            <li>au moins <strong>1 lettre minuscule</strong></li>
                            <li>au moins <strong>1 chiffre</strong></li>
                            <li>au moins <strong>1 caractère spécial</strong> (! @ # $ % …)</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn-activation-submit">
                        Activer mon compte
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="./js/alerts.js"></script>
    </body>
    </html>
    <?php

}
#endregion