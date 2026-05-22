<?php
require_once __DIR__ . '/../../lang/init_lang.php';
global $t;
?>

<div class="course-page">
  <div class="course-card">

    <?php if (!empty($messageKey)): ?>
      <div class="alert-container-cours">
        <p class="alert <?= $messageType === 'vu' ? 'alert-vu' : 'alert-nonvu' ?>">
        <?= htmlspecialchars($t[$messageKey] ?? $messageKey) ?>
        </p>
      </div>
      <script src="./js/alerts.js"></script>
    <?php endif; ?>

    <!-- Go back button -->
    <a class="back-button" href="<?= htmlspecialchars($_SESSION['previous_course_page'] ?? 'index.php?page=cours') ?>">
      <?= $t['course_back'] ?>
    </a>

    <h1 class="titre-de-cours"><?= htmlspecialchars($cours->getTitre()) ?></h1>
    <p class="course-description"><?= htmlspecialchars($cours->getDescription()) ?></p>
    <p class="course-author">
      <?= $t['course_author'] ?>
      <?= htmlspecialchars($cours->getAuteur()) ?: $t['course_author_unknown'] ?>
    </p>

    <!-- PDF container -->
    <div class="pdf-viewer">
      <iframe src="file.php?name=<?= urlencode($cours->getFichier()) ?>" width="100%" height="100%" style="border:0;"></iframe>
    </div>

    <!-- Download file button -->
    <p class="download-button">
      <a class="download-link" href="file.php?name=<?= urlencode($cours->getFichier()) ?>" target="_blank">
        <?= $t['course_download'] ?>
      </a>
    </p>

    <!-- Change status button -->
    <div class="course-status">
      <p class="course-status-text">
        <?php if (!empty($isCompleted)): ?>
          <?= $t['course_status_completed_text'] ?? "Ce cours est marqué comme vu :"; ?>
        <?php else: ?>
          <?= $t['course_status_not_completed_text'] ?? "Ce cours n'est pas encore marqué comme vu :"; ?>
        <?php endif; ?>
      </p>

      <form class="course-completion-form" method="post" action="index.php?page=cours_lecture&id=<?= (int)$cours->getId(); ?>">

        <button type="submit" name="toggle_completion" value="1" class="course-completion-btn 
          <?= !empty($isCompleted) ? 'course-completion-btn--on' : 'course-completion-btn--off' ?>" >

          <?php if (!empty($isCompleted)): ?>
            <?= $t['course_button_seen'] ?? "Marquer comme non vu"; ?>
          <?php else: ?>
            <?= $t['course_button_not_seen'] ?? "Marquer comme vu"; ?>
          <?php endif; ?>

        </button>
      </form>
    </div>


  </div>
</div>
