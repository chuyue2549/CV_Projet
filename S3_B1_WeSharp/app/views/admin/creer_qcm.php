<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- Qcm creation page -->
<div class="page-cree">

  <div class="background-bottom  background-bottom-qcm"></div>

  <section class="create-course-wrapper">
    <form action="index.php?page=admin&action=creer_qcm" method="post" id="qcmForm">

      <h2 class="subtitle-admin"><?= $t['admin_create_qcm_title'] ?></h2>

      <div class="course-section">
        <h2><?= $t['admin_create_qcm_step1'] ?></h2>

        <div class="form-group">
          <label for="titre"><?= $t['admin_create_course_label_title'] ?></label>
          <input type="text" id="titre" name="titre" required placeholder="Ex : Quiz de C#">
        </div>

        <div class="form-group">
          <label for="niveau"><?= $t['admin_create_course_label_level'] ?></label>
          <input type="number" id="niveau" name="niveau" required placeholder="Ex : 1">
        </div>

        <div class="form-group">
          <label for="matiere"><?= $t['admin_create_course_label_subject'] ?></label>
          <select name="matiere_id" id="matiere" required>
            <?php foreach ($matieres as $m): ?>
              <option value="<?= htmlspecialchars($m->getId()) ?>">
                <?= htmlspecialchars($m->getTitre()) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="course-section">
        <h2><?= $t['admin_create_qcm_step2'] ?></h2>

        <div id="questions-container">

          <div class="question-block" data-index="0">
            <div class="form-group">
              <label><?= $t['admin_create_qcm_label_statement'] ?></label>
              <input type="text" name="questions[0][enonce]" placeholder="Ex : Qu'est-ce qu'une variable" required>
            </div>

            <?php for ($j = 0; $j < 4; $j++): ?>
              <div class="question-row">
                <input type="text" class="question-input" name="questions[0][reponses][<?= $j ?>][texte]" placeholder="Réponse <?= $j+1 ?>" <?php if ($j < 2): ?>required<?php endif; ?> >
                <label class="question-good-answer">
                  <input type="checkbox" name="questions[0][reponses][<?= $j ?>][is_correct]" value="1">
                </label>
              </div>
            <?php endfor; ?>

            <div class="btn-question">
              <button type="button" id="add-question" class="btn-secondary small-btn">+</button>
              <button type="button" class="delete-question"><?= $t['admin_create_qcm_delete_question'] ?></button>
            </div>

          </div>

        </div>
      </div>

      <div class="course-section">
        <h2><?= $t['admin_create_qcm_step3'] ?></h2>
        <div class="course-actions">
          <a href="index.php?page=admin" class="btn-secondary"><?= $t['admin_cancel'] ?></a>
          <button type="submit" name="submit" class="btn-primary"><?= $t['admin_save_qcm'] ?></button>
        </div>
      </div>

      <script src="./js/qcm-form.js"></script>
    </form>
  </section>
</div>