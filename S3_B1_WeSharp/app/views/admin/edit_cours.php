<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<section class="page-modif">

    <section class="modif-course-wrapper">

        <form action="index.php?page=admin&action=update_cours" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $cours->getId() ?>">

                <div class="form-group">
                    <label for="titre"><?= $t['course_edit_label_title'] ?></label>
                    <input type="text" id="titre" name="titre"
                           value="<?= htmlspecialchars($cours->getContenu()->getTitre()) ?>">
                </div>

                <div class="form-group">
                    <label for="description"><?= $t['course_edit_label_description'] ?></label>
                    <textarea id="description" name="description"><?= htmlspecialchars($cours->getDescription()) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="niveau"><?= $t['course_edit_label_level'] ?></label>
                    <input type="number" id="niveau" name="niveau"
                           value="<?= $cours->getContenu()->getNiveau() ?>">
                </div>

                <div class="form-group">
                    <label for="matiere"><?= $t['course_edit_label_subject'] ?></label>
                    <select name="matiere" id="matiere">

                        <?php foreach($matieres as $m): ?>
                            <option value="<?= $m->getId() ?>"
                                <?= $m->getId() == $cours->getContenu()->getMatiereId() ? "selected":"" ?>>
                                <?= htmlspecialchars($m->getTitre()) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="auteur"><?= $t['course_edit_label_author'] ?></label>
                    <select name="auteur" id="auteur">

                        <?php foreach($auteurs as $a): ?>
                            <option value="<?= $a->getId() ?>"
                                <?= $a->getId() == $cours->getContenu()->getAuteurId() ? "selected":"" ?>>
                                <?= htmlspecialchars($a->getPrenom().' '.$a->getNom()) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="fichier"><?= $t['course_edit_label_file'] ?></label>
                    <input type="file" id="fichier" name="fichier">
                </div>

                <div class="form-group">
                    <label>
                        <?= $t['course_edit_label_published'] ?>
                        <input type="checkbox" name="pub"
                            <?= $cours->getContenu()->isPublished() ? "checked":"" ?>>
                    </label>
                </div>

                <div class="btn-modif">

                    <a href="index.php?page=admin&action=voir_cours"
                       class="btn-annuler"><?= $t['course_edit_cancel'] ?></a>

                    <button type="submit" class="btn-confirmer"><?= $t['course_edit_confirm'] ?></button>

                </div>

        </form>

    </section>
</section>
