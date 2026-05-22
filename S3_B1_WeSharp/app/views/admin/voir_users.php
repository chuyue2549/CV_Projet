<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- List of the users -->
<h2><?= $t['admin_list_users_title'] ?></h2>

<?php if (!empty($usersList)): ?>
    <table class="courses-table">
    <thead>
        <tr>
        <th><?= $t['admin_course_column_number'] ?></th>
        <th><?= $t['admin_user_column_firstname'] ?></th>
        <th><?= $t['admin_user_column_lastname'] ?></th>
        <th><?= $t['admin_user_column_email'] ?></th>
        <th><?= $t['admin_user_column_role'] ?></th>
        <th colspan="2"><?= $t['admin_course_column_actions'] ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usersList as $u): ?>
        <?php 
            $user = $u['user'];
            $compte = $u['compte'];
        ?>
        <tr>
            <td class="cell-title"><?= (int)$user->getId() ?></td>
            <td><?= htmlspecialchars($user->getPrenom()) ?></td>
            <td><?= htmlspecialchars($user->getNom()) ?></td>
            <td><?= htmlspecialchars($compte->getEmail()) ?></td>
            <td class="cell-role">

            <?php if ($user->getId() == $_SESSION['compte']['user_id']): ?>

                <!-- L'admin ne peut pas modifier son propre rôle -->
                <span id="role-admin"><?= ucfirst(mb_strtolower(trim($user->getRole()), 'UTF-8')) ?></span>

            <?php else: ?>

                <form action="index.php?page=admin&action=modifier_role" method="post">
                    <input type="hidden" name="user_id" value="<?= $user->getId() ?>">

                    <select name="role"
                            data-old="<?= $user->getRole() ?>"
                            onchange="confirmRoleChange(this)">
                        <option value="etudiant" <?= $user->getRole()==='etudiant' ? 'selected' : '' ?>>Étudiant</option>
                        <option value="directeur" <?= $user->getRole()==='directeur' ? 'selected' : '' ?>>Directeur</option>
                        <option value="admin" <?= $user->getRole()==='admin' ? 'selected' : '' ?>>Administrateur</option>
                    </select>
                </form>

            <?php endif; ?>
            <script>
            function confirmRoleChange(select){

                let oldRole = select.dataset.old;

                let msg = "Voulez-vous vraiment modifier le rôle de cet utilisateur ?";

                if (confirm(msg)) {
                    // utilisateur confirme : on envoie
                    select.form.submit();
                } 
                else {
                    // utilisateur annule : on remet l'ancien rôle
                    select.value = oldRole;
                }
            }
            </script>

        </td>

            <td>
            <?php if ($compte->isActive()): ?>
                <a href="index.php?page=admin&action=toggle_user&id=<?= $user->getId() ?>">
                <button class="unpublish-btn"><?= $t['admin_user_deactivate'] ?></button>
                </a>
            <?php else: ?>
                <a href="index.php?page=admin&action=toggle_user&id=<?= $user->getId() ?>">
                <button class="publish-btn"><?= $t['admin_user_activate'] ?></button>
                </a>
            <?php endif; ?>
            </td>

            <td>
                <a class="btn-link"
                href="index.php?page=admin&action=supprimer_user&id=<?= $user->getId() ?>"
                onclick="return confirm('<?= $t['admin_confirm_delete_user'] ?>');">
                    <?= $t['admin_delete'] ?>
                </a>
            </td>

        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
<?php else: ?>
    <p><?= $t['admin_no_users'] ?></p>
<?php endif; ?>

<a href="index.php?page=admin">
    <button class="return-btn"><?= $t['admin_back'] ?></button>
</a>