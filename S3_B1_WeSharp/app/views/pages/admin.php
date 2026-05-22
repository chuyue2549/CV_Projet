<?php 
require_once __DIR__ . '/../../lang/init_lang.php'; 
global $t;
?>

<section class="page-admin">

    <div class="admin-header">
        <h1><?= $t['admin_title'] ?></h1>
    </div>

    <?php 
        // Admin page templates
        $views = [
            null            => 'dashboard',
            'creer_cours'   => 'creer_cours',
            'voir_cours'    => 'voir_cours',
            'edit_cours'  => 'edit_cours',
            'creer_qcm'     => 'creer_qcm',
            'voir_qcm'      => 'voir_qcm',
            'edit_qcm'    => 'edit_qcm',
            'voir_users'    => 'voir_users',
            'creer_compte'  => 'creer_compte',
        ];

        $viewName = $views[$action] ?? 'dashboard';

        require __DIR__ . "/../admin/$viewName.php";
    ?>

</section>