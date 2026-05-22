<?php
require_once __DIR__ . '/../../lang/init_lang.php';
global $t;
?>

<section class="page-qcm">
  <form class="search-block" method="get" action="index.php">
    <input type="hidden" name="page" value="qcm">

    <div class="text">
      <h1><?= $t['qcm_title']; ?></h1>
      <p><?= $t['qcm_subtitle']; ?></p>
    </div>
    
    <div class="search-row">
      <input
        type="search"
        id="search-input"
        name="q"
        placeholder="<?= $t['qcm_search_placeholder']; ?>"
        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
      >

      <button type="submit" id="search-button">
        <?= $t['qcm_search_button']; ?>
      </button>
      <button type="button" id="filter-button">
        <?= $t['qcm_filter_button']; ?>
      </button>
    </div>

    <div class="filter-panel" id="filter-panel" aria-hidden="true">

      <div class="filter-header">
        <h2><?= $t['qcm_filter_title']; ?></h2>
        <button type="button" id="close-filter-button">✕</button>
      </div>

      <!-- Bloc 1 : Niveau -->
      <section class="filter-block">
        <h3><?= $t['qcm_filter_level']; ?></h3>

        <input type="radio" name="niveau" id="niveau-all" value="">
        <label for="niveau-all"><?= $t['qcm_filter_level_all']; ?></label>

        <?php if (!empty($niveaux)): ?>
          <?php foreach ($niveaux as $n): ?>
            <?php $id = 'niveau-' . (int)$n['niveau']; ?>

            <input
              type="radio"
              name="niveau"
              id="<?= $id ?>"
              value="<?= (int)$n['niveau'] ?>"
            >
            <label for="<?= $id ?>"><?= htmlspecialchars($n['niveau']) ?></label>

          <?php endforeach; ?>
        <?php endif; ?>
      </section>

      <!-- Bloc 2 : Matière -->
      <section class="filter-block">
        <h3><?= $t['qcm_filter_subject']; ?></h3>

        <input type="radio" name="matiere" id="matiere-all" value="">
        <label for="matiere-all"><?= $t['qcm_filter_subject_all']; ?></label>

        <?php if (!empty($matieres)): ?>
          <?php foreach ($matieres as $m): ?>
            <?php $id = 'matiere-' . $m->getId(); ?>

            <input
              type="radio"
              name="matiere"
              id="<?= $id ?>"
              value="<?= $m->getId() ?>"
            >
            <label for="<?= $id ?>"><?= $m->getTitre() ?></label>

          <?php endforeach; ?>
        <?php endif; ?>
      </section>

      <!-- Bloc 3-->
      <div class="filter-footer">
        <button type="button" id="cancel-filter">
          <?= $t['qcm_filter_cancel']; ?>
        </button>
        <button type="submit" id="resulta">
          <?= $t['qcm_filter_submit']; ?>
        </button>
      </div>

    </div>
  </form>
 
  <!-- JS script used to sort the QCMs -->
  <script src="./js/qcm-filters.js"></script>

  <!-- Lists all of the QCMs -->
  <?php if (empty($qcms)): ?>
    <p class="qcm-empty"><?= $t['qcm_empty']; ?></p>
  <?php else: ?>

    <div class="qcm-list">
      <?php foreach ($qcms as $qcm): ?>

        <div class="qcm-card">
          
          <div class="main">
            <h3><?= htmlspecialchars($qcm->getTitre()) ?></h3>

            <div class="middle">
              <p><?= $t['qcm_label_subject']; ?><?= htmlspecialchars($qcm->getMatiere()) ?></p>
              <p><?= $t['qcm_label_level']; ?><?= htmlspecialchars($qcm->getNiveau()) ?></p>
            </div>

            <div class="action">
              <form method="get" action="index.php">
                <input type="hidden" name="page" value="qcm_start">
                <input type="hidden" name="id" value="<?= $qcm->getId() ?>">
                <button type="submit">
                  <?= $t['qcm_start_button']; ?>
                </button>
              </form>
            </div>

          </div>

          <!-- pas encore connecté avec BDD -->
          <aside class="vide">
            <p><?= $t['qcm_sidebar_progress']; ?></p>
          </aside>

        </div>
      <?php endforeach; ?>
    </div>

  <?php endif; ?>
</section>
