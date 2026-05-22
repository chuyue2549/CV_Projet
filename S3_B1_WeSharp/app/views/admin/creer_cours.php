<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- Course creation page -->
<div class="page-cree">

    <div class="background-bottom background-bottom-cours"></div>

    <section class="create-course-wrapper">
        <h2 class="subtitle-admin"><?= $t['admin_create_course_title'] ?></h2>
        <form action="index.php?page=admin&action=creer_cours" method="post" enctype="multipart/form-data">

        <div class="course-section">
            <h2><?= $t['admin_create_course_step1'] ?></h2>

            <div class="form-group">
            <label for="titre"><?= $t['admin_create_course_label_title'] ?></label>
            <input type="text" id="titre" name="titre" required placeholder="Ex : Cours de C#" autofocus>
            </div>

            <div class="form-group">
            <label for="niveau"><?= $t['admin_create_course_label_level'] ?></label>
            <input type="number" id="niveau" name="niveau" required placeholder="Ex : 1">
            </div>

            <div class="form-group">
            <label for="matiere"><?= $t['admin_create_course_label_subject'] ?></label>
            <select name="matiere" id="matiere" required>
                <?php foreach ($matieres as $m): ?>
                <option value="<?= htmlspecialchars($m->getId()) ?>">
                    <?= htmlspecialchars($m->getTitre()) ?>
                </option>
                <?php endforeach; ?>
            </select>
            </div>

            <div class="form-group">
            <label for="auteur"><?= $t['admin_create_course_label_author'] ?></label>
            <select name="auteur" id="auteur" required>
                <?php foreach ($auteurs as $a): ?>
                <option value="<?= htmlspecialchars($a->getId()) ?>">
                    <?= htmlspecialchars($a->getNom()) ?> <?= htmlspecialchars($a->getPrenom()) ?>
                </option>
                <?php endforeach; ?>
            </select>
            </div>

            <div class="form-group">
            <label for="description"><?= $t['admin_create_course_label_description'] ?></label>
            <textarea id="description" name="description" placeholder="..."></textarea>
            </div>
        </div>

        <div class="course-section">
            <h2><?= $t['admin_create_course_step2'] ?></h2>

            <div class="form-group">
            <label for="fichier"><?= $t['admin_create_course_label_file'] ?></label>
            <input type="file" id="fichier" name="fichier" accept="application/pdf" required>
            </div>
        </div>

        <div class="course-section">
            <h2><?= $t['admin_create_course_step3'] ?></h2>
            <div class="course-actions">
            <a href="index.php?page=admin" class="btn-secondary"><?= $t['admin_cancel'] ?></a>
            <button type="submit" name="submit" class="btn-primary"><?= $t['admin_save_course'] ?></button>
            </div>
        </div>

        </form>
    </section>
</div>