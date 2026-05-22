<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<section class="page-modif">

    <section class="modif-course-wrapper">
        <form action="index.php?page=admin&action=update_qcm" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $qcm->getId() ?>">
            <h2><?= $t['qcm_edit_title'] ?></h2>

            <div class="form-group">
                <label><?= $t['qcm_edit_label_title'] ?></label>
                <input type="text"
                    name="titre"
                    value="<?= htmlspecialchars($qcm->getTitre()) ?>"
                    required>
            </div>

            <div class="form-group">
                <label><?= $t['qcm_edit_label_level'] ?></label>
                <input type="number"
                    name="niveau"
                    value="<?= $qcm->getNiveau() ?>"
                    required>
            </div>

            <div class="form-group">
                <label><?= $t['qcm_edit_label_subject'] ?></label>
                <select name="matiere" required>
                    <?php foreach($matieres as $m): ?>
                        <option value="<?= $m->getId() ?>"
                            <?= $m->getId() == $qcm->getContenu()->getMatiereId() ? "selected":"" ?>>
                            <?= htmlspecialchars($m->getTitre()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <h2><?= $t['qcm_edit_questions_title'] ?></h2>

            <div id="questions-container">

                <?php foreach($questions as $qi => $question): ?>

                <div class="question-block">
                    <input type="hidden"
                            name="questions[<?= $qi ?>][id]"
                            value="<?= $question->getId() ?>">

                    <div class="form-group">
                        <label><?= $t['qcm_edit_label_statement'] ?></label>
                        <input type="text"
                            name="questions[<?= $qi ?>][enonce]"
                            value="<?= htmlspecialchars($question->getEnonce()) ?>"
                            required>
                    </div>

                    <?php foreach($question->getReponses() as $ri => $rep): ?>

                        <div class="question-row">
                            <input type="hidden"
                                    name="questions[<?= $qi ?>][reponses][<?= $ri ?>][id]"
                                    value="<?= $rep->getId() ?>">

                            <input type="text"
                                name="questions[<?= $qi ?>][reponses][<?= $ri ?>][texte]"
                                value="<?= htmlspecialchars($rep->getReponse()) ?>"
                                required>

                            <input type="hidden"
                                   name="questions[<?= $qi ?>][reponses][<?= $ri ?>][is_correct]"
                                   value="0">

                            <label>
                                <input type="checkbox"
                                    name="questions[<?= $qi ?>][reponses][<?= $ri ?>][is_correct]"
                                    value="1"
                                    <?= $rep->isCorrect() ? "checked":"" ?>>
                            </label>
                        </div>

                    <?php endforeach; ?>

                </div>

                <?php endforeach; ?>

            </div>

            <div class="qcm-actions">
                <a href="index.php?page=admin&action=voir_qcm" class="btn-annuler">
                    <?= $t['qcm_edit_cancel'] ?>
                </a>
                <button type="submit" class="btn-confirmer">
                    <?= $t['qcm_edit_confirm'] ?>
                </button>
            </div>

        </form>
    </section>
</section>
