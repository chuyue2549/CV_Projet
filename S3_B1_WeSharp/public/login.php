<?php
require_once __DIR__ . '/../app/config/constants.php';

session_start();
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['error'], $_SESSION['success']);
?>


<!DOCTYPE html>
<html lang="fr">
<!-- Header -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Window logo -->
    <link rel="shortcut icon" href="./images/debut.png">
    <!-- Window name -->
    <title><?=WEBSITE_NAME?> - Connexion</title>
    <!-- Steelsheet -->
    <link rel="stylesheet" href="./styles/style.css">

    <!-- Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <section class="page-login">
        <div class="connection-block">
            <div class="connection-wrapper">
                <div class="title">
                    <img src="./images/debut.png" alt="Logo du site">
                    <h1 class="subtitle-connexion">Connexion</h1>
                </div>

                <form method="POST" action="index.php?page=login" class="connection-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" placeholder="Votre email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                    </div>

                    <?php if ($success): ?>
                        <p class="alert alert-success"><?= htmlspecialchars($success) ?></p>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <p class="alert alert-error"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>

                    <button type="submit" class="btn-connection-submit">Se connecter</button>
                </form>
                <a href="#" class="forgot-link">
                    <i class="fa-solid fa-circle-question"></i>
                    Mot de passe oublié ?
                </a>
            </div>
        </div>
    </section>
</body>