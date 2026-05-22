<?php
require_once __DIR__ . '/../../lang/init_lang.php';
global $t;
?>

<!-- Main page -->
<section class="page-accueil">
    <div class="accueil-top">
        <h1><?= $t['home_title']; ?></h1>

        <p>
            <?= $t['home_subtitle']; ?>
        </p>
    </div>

    <div class="accueil-background"></div>

    <!-- Section with category cards -->
    <div class="cards-container">

        <!-- Cours card -->
        <a href="./index.php?page=cours" class="card">
            <h2><?= $t['home_card_courses_title']; ?></h2>
            <p><?= $t['home_card_courses_text']; ?></p>
        </a>

        <!-- Exercices card -->
        <a href="./index.php?page=exercices" class="card">
            <h2><?= $t['home_card_exercices_title']; ?></h2>
            <p><?= $t['home_card_exercices_text']; ?></p>
        </a>

        <!-- QCM card -->
        <a href="./index.php?page=qcm" class="card">
            <h2><?= $t['home_card_qcm_title']; ?></h2>
            <p><?= $t['home_card_qcm_text']; ?></p>
        </a>

    </div>

    <!-- Petit switch de langue juste pour tester -->
    <div class="lang-switcher" style="margin-top: 20px;">
        <a href="?page=accueil&lang=fr"><?= $t['lang_fr']; ?></a> |
        <a href="?page=accueil&lang=en"><?= $t['lang_en']; ?></a>
    </div>
</section>
