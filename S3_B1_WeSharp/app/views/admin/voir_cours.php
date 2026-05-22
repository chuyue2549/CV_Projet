<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- Lists of the courses -->
<h2><?= $t['admin_list_courses_title'] ?></h2>

<?php if (!empty($coursList)): ?>
<table class="courses-table">
    <thead>
    <tr>
        <th><?= $t['admin_course_column_number'] ?></th>
        <th><?= $t['admin_course_column_title'] ?></th>
        <th><?= $t['admin_course_column_description'] ?></th>
        <th><?= $t['admin_course_column_level'] ?></th>
        <th><?= $t['admin_course_column_subject'] ?></th>
        <th><?= $t['admin_course_column_author'] ?></th>
        <th colspan="4"><?= $t['admin_course_column_actions'] ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($coursList as $c): ?>
        <tr>
        <td class="cell-title"><?= (int)$c->getId() ?></td>
        <td><?= htmlspecialchars($c->getTitre()) ?></td>
        <td><?= htmlspecialchars($c->getDescription()) ?></td>
        <td><?= htmlspecialchars($c->getNiveau()) ?></td>
        <td><?= htmlspecialchars($c->getMatiere()) ?></td>
        <td><?= htmlspecialchars($c->getAuteur()) ?></td>
        <td class="cell-actions">
            <a class="btn-link" href="index.php?page=cours_lecture&id=<?= urlencode($c->getId()) ?>">
            <?= $t['admin_course_view'] ?>
            </a>
        </td>
        <td>
            <a class="btn-link" 
            href="index.php?page=admin&action=edit_cours&id=<?= $c->getId() ?>">
            <?= $t['admin_edit'] ?>
            </a>
        </td>
        <td>
            <?php if ($c->isPublished()): ?>
            <a href="index.php?page=admin&action=toggle_publication_cours&id=<?= $c->getId() ?>">
                <button class="unpublish-btn"><?= $t['admin_unpublish'] ?></button>
            </a>
            <?php else: ?>
            <a href="index.php?page=admin&action=toggle_publication_cours&id=<?= $c->getId() ?>">
                <button class="publish-btn"><?= $t['admin_publish'] ?></button>
            </a>
            <?php endif; ?>
        </td>
        <td>
            <a class="btn-link" 
                href="index.php?page=admin&action=supprimer_cours&id=<?= $c->getId() ?>" 
                onclick="return confirm('<?= $t['admin_confirm_delete_course'] ?>');">
                <?= $t['admin_delete'] ?>
            </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p><?= $t['admin_no_courses'] ?></p>
<?php endif; ?>

<a href="index.php?page=admin">
<button class="return-btn"><?= $t['admin_back'] ?></button>
</a>