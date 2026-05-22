<?php
require_once __DIR__ . '/../../lang/init_lang.php';
global $t;
?>

<!-- Quiz result -->
<div class="qcm-wrapper">

  <div class="qcm-box qcm-result-box">

    <h1><?= $t['qcm_result_title'] ?></h1>

    <div class="qcm-result-summary">
      <span><?= $score ?>/<?= $total ?> <?= $t['qcm_result_correct_suffix'] ?></span>
      <span>(<?= $pourcentage ?> %)</span>
    </div>

    <?php if ($pourcentage == 100): ?>
      <p class="qcm-global-msg qcm-global-ok"><?= $t['qcm_result_msg_perfect'] ?></p>
    <?php elseif ($pourcentage >= 70): ?>
      <p class="qcm-global-msg qcm-global-ok"><?= $t['qcm_result_msg_good'] ?></p>
    <?php elseif ($pourcentage >= 50): ?>
      <p class="qcm-global-msg qcm-global-mid"><?= $t['qcm_result_msg_ok'] ?></p>
    <?php else: ?>
      <p class="qcm-global-msg qcm-global-ko"><?= $t['qcm_result_msg_retry'] ?></p>
    <?php endif; ?>

    <?php if (!empty($details)): ?>
      <div class="qcm-result-list">
        <?php foreach ($details as $d): ?>
          <div class="qcm-result-question">

            <!-- Question -->
            <p class="qcm-result-question-title">
              <?= htmlspecialchars($d['question']->getEnonce()) ?>
            </p>

            <?php if ($d['correct']): ?>
              <!-- Correct answer(s) -->
              <p class="qcm-result-msg qcm-ok">
                ✔ <?= $t['qcm_result_correct_answers'] ?>
                <?php foreach ($d['choisies'] as $r): ?>
                  <ul>
                    <li><?= htmlspecialchars($r->getReponse()) ?></li>
                  </ul>
                <?php endforeach; ?>
              </p>
            <?php else: ?>

              <!-- Incorrect answer -->
              <p class="qcm-result-msg qcm-ko">
                ✘ <?= $t['qcm_result_your_answers'] ?>
                <?php if (!empty($d['choisies'])): ?>
                    <?php foreach ($d['choisies'] as $r): ?>
                      <ul>
                        <li><?= htmlspecialchars($r->getReponse()) ?></li>
                      </ul>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span><?= $t['qcm_result_none'] ?></span>
                <?php endif; ?>
              </p>

              <p class="qcm-result-msg qcm-ok">
                ✔ <?= $t['qcm_result_correct_answers'] ?>
                <?php foreach ($d['bonnes'] as $r): ?>
                  <ul>
                    <li><?= htmlspecialchars($r->getReponse()) ?></li>
                  </ul>
                <?php endforeach; ?>
              </p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="qcm-result-buttons">
      <a href="<?= htmlspecialchars($_SESSION['previous_qcm_page'] ?? 'index.php?page=qcm') ?>" class="qcm-submit qcm-result-back">
        <?= $t['qcm_run_back_to_list'] ?>
      </a>

      <a href="index.php?page=qcm_start&id=<?= $id ?>" class="qcm-submit qcm-result-retry">
        <?= $t['qcm_result_retry_this'] ?>
      </a>
    </div>

  </div>

</div>

