<?php
require_once __DIR__ . '/../../lang/init_lang.php';
global $t;
?>

<div class="qcm-wrapper">

  <div class="qcm-box">

    <h1><?= $t['qcm_run_title'] ?></h1>
    <p class="qcm-subtitle"><?= $t['qcm_run_subtitle'] ?></p>

    <p class="qcm-question-title"><?= $t['qcm_run_question_prefix'] ?><?= htmlspecialchars($qcm->getTitre()) ?></p>

    <p class="qcm-enonce"><?= htmlspecialchars($question->getEnonce()) ?></p>

    <form method="post" action="index.php?page=qcm_questions">
      <?php foreach ($reponses as $r): ?>
        <label class="qcm-answer">
          <input type="checkbox" name="reponses[]" value="<?= $r->getId() ?>">
          <span><?= htmlspecialchars($r->getReponse()) ?></span>
        </label>
      <?php endforeach; ?>

      <div class="qcm-buttons">
        <button type="submit" class="qcm-submit">
          <?= $isLast ? $t['qcm_run_button_result'] : $t['qcm_run_button_next'] ?>
        </button>

        <a href="<?= htmlspecialchars($_SESSION['previous_qcm_page'] ?? 'index.php?page=qcm') ?>"
           class="qcm-submit qcm-result-back"
           onclick="return confirm('<?= $t['qcm_run_confirm_exit'] ?>');">
          <?= $t['qcm_run_back_to_list'] ?>
        </a>

      </div>
    </form>
  </div>
</div>
