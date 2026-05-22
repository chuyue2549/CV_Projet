<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- List of the qcms -->
<h2><?= $t['admin_list_qcms_title'] ?></h2>

<?php if (!empty($qcmList)): ?>
<table class="courses-table">
    <thead>
    <tr>
        <th><?= $t['admin_course_column_number'] ?></th>
        <th><?= $t['admin_course_column_title'] ?></th>
        <th><?= $t['admin_course_column_level'] ?></th>
        <th><?= $t['admin_course_column_subject'] ?></th>
        <th colspan="4"><?= $t['admin_course_column_actions'] ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($qcmList as $q): ?>
        <tr>
        <td class="cell-title"><?= (int)$q->getId() ?></td>
        <td><?= htmlspecialchars($q->getTitre()) ?></td>
        <td><?= htmlspecialchars($q->getNiveau()) ?></td>
        <td><?= htmlspecialchars($q->getMatiere()) ?></td>

        <td class="cell-actions">
            <a class="btn-link" href="index.php?page=qcm_start&id=<?= urlencode($q->getId()) ?>">
            <?= $t['admin_take_qcm'] ?>
            </a>
        </td>
        <td>
            <a class="btn-link" href="?page=admin&action=edit_qcm&id=<?= $q->getId() ?>">
            <?= $t['admin_edit'] ?>
            </a>
        </td>
        <td>
            <?php if ($q->isPublished()): ?>
            <a href="index.php?page=admin&action=toggle_publication_qcm&id=<?= $q->getId() ?>">
                <button class="unpublish-btn"><?= $t['admin_unpublish'] ?></button>
            </a>
            <?php else: ?>
            <a href="index.php?page=admin&action=toggle_publication_qcm&id=<?= $q->getId() ?>">
                <button class="publish-btn"><?= $t['admin_publish'] ?></button>
            </a>
            <?php endif; ?>
        </td>

        <td>
            <a class="btn-link"
            href="index.php?page=admin&action=supprimer_qcm&id=<?= $q->getId() ?>"
            onclick="return confirm('<?= $t['admin_confirm_delete_qcm'] ?>');">
            <?= $t['admin_delete'] ?>
            </a>
        </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p><?= $t['admin_no_qcm'] ?></p>
<?php endif; ?>

<a href="index.php?page=admin">
<button class="return-btn"><?= $t['admin_back'] ?></button>
</a>