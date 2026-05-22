<?php 
require_once __DIR__ . '/../../lang/init_lang.php'; 
global $t;
?>

<section class="page-cours">
  <div class="search-area">
    <!-- Barre de recherche -->
    <form class="search-block" method="get" action="index.php">
      <input type="hidden" name="page" value="cours">

      <div class="text">
        <h1><?= $t['courses_title']; ?></h1>
        <p><?= $t['courses_subtitle']; ?></p>
      </div>
      
      <div class="search-row">
        <input 
          type="search" 
          id="search-input" 
          name="q" 
          placeholder="<?= $t['courses_search_placeholder']; ?>" 
          value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
        >

        <button type="submit" id="search-button">
          <?= $t['courses_search_button']; ?>
        </button>

        <button type="button" id="filter-button">
          <?= $t['courses_filter_button']; ?>
        </button>
      </div>
    </form>

    <!-- PANNEAU DES FILTRES -->
    <div class="filter-panel" id="filter-panel" aria-hidden="true">

      <div class="filter-header">
        <h2><?= $t['courses_filter_title']; ?></h2>
        <button type="button" id="close-filter-button">✕</button>
      </div>

      <form method="get" action="index.php">
        <input type="hidden" name="page" value="cours">

        <!-- Filtre Niveau -->
        <section class="filter-block">
          <h3><?= $t['courses_filter_level']; ?></h3>

          <input type="radio" name="niveau" id="niveau-all" value="">
          <label for="niveau-all"><?= $t['courses_filter_level_all']; ?></label>

          <?php if (!empty($niveaux)): ?>
            <?php foreach ($niveaux as $n): ?>
              <?php $id = 'niveau-' . (int)$n['niveau']; ?>
              <input type="radio" name="niveau" id="<?= $id ?>" value="<?= (int)$n['niveau'] ?>">
              <label for="<?= $id ?>"><?= htmlspecialchars($n['niveau']) ?></label>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>

        <!-- Filtre Matière -->
        <section class="filter-block">
          <h3><?= $t['courses_filter_subject']; ?></h3>

          <input type="radio" name="matiere" id="matiere-all" value="">
          <label for="matiere-all"><?= $t['courses_filter_subject_all']; ?></label>

          <?php if (!empty($matieres)): ?>
            <?php foreach ($matieres as $m): ?>
              <?php $id = 'matiere-' . $m->getId(); ?>
              <input type="radio" name="matiere" id="<?= $id ?>" value="<?= $m->getId() ?>">
              <label for="<?= $id ?>"><?= htmlspecialchars($m->getTitre()) ?></label>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>

        <!-- Boutons -->
        <div class="filter-footer">
          <button type="button" id="cancel-filter">
            <?= $t['courses_filter_cancel']; ?>
          </button>

          <button type="submit" id="resulta">
            <?= $t['courses_filter_submit']; ?>
          </button>
        </div>

      </form>
    </div>
  </div>

  <!-- JS des filtres -->
  <script defer src="./js/course-filters.js"></script>

  <!-- Liste des cours -->
  <?php if (empty($cours)): ?>
    
    <p class="cours-empty"><?= $t['courses_empty']; ?></p>

  <?php else: ?>
    <div class="cours-list">

      <?php foreach ($cours as $c): ?>
        <?php 
          $coursId = (int)$c->getId();
          $isCompleted = $completedMap[$coursId] ?? false;
        ?>

        <div class="cours-card">

          <!-- Partie principale -->
          <div class="main">
            <h3><?= htmlspecialchars($c->getTitre()) ?></h3>

            <p class="auteur">
              <?= $t['courses_by_author_prefix']; ?>
              <?= htmlspecialchars($c->getAuteur()) ?>
            </p>

            <div class="middle">
              <p><?= $t['courses_label_subject']; ?><?= htmlspecialchars($c->getMatiere()) ?></p>
              <p><?= $t['courses_label_level']; ?><?= htmlspecialchars($c->getNiveau()) ?></p>
            </div>

            <p class="desc">
              <?= $t['courses_label_description']; ?>
              <?= htmlspecialchars($c->getDescription()) ?>
            </p>

            <div class="action">
              <form method="get" action="index.php">
                <input type="hidden" name="page" value="cours_lecture">
                <input type="hidden" name="id" value="<?= $coursId ?>">
                <button type="submit"><?= $t['courses_view_button']; ?></button>
              </form>
            </div>
          </div>

          <!-- Statut -->
          <aside class="status">
            <?php if ($isCompleted): ?>
              <p><?= $t['course_status_completed']; ?></p>
            <?php else: ?>
              <p><?= $t['course_status_not_completed']; ?></p>
            <?php endif; ?>
          </aside>

        </div>

      <?php endforeach; ?>

    </div>
  <?php endif; ?>

</section>
