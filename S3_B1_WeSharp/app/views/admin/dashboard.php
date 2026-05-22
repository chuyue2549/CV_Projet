<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- Dashboard page -->
<div class="admin-card-container">

    <div class="admin-card">
    <h3><?= $t['admin_card_courses_title'] ?></h3>
    <p><?= $t['admin_card_courses_desc'] ?></p>
    <a href="index.php?page=admin&action=voir_cours">
        <button class="admin-btn"><?= $t['admin_card_courses_title'] ?></button>
    </a>
    </div>

    <div class="admin-card">
    <h3><?= $t['admin_card_qcms_title'] ?></h3>
    <p><?= $t['admin_card_qcms_desc'] ?></p>
    <a href="index.php?page=admin&action=voir_qcm">
        <button class="admin-btn"><?= $t['admin_card_qcms_title'] ?></button>
    </a>
    </div>

    <div class="admin-card">
    <h3><?= $t['admin_card_create_course_title'] ?></h3>
    <p><?= $t['admin_card_create_course_desc'] ?></p>
    <a href="index.php?page=admin&action=creer_cours">
        <button class="admin-btn"><?= $t['admin_card_create_course_title'] ?></button>
    </a>
    </div>

    <div class="admin-card">
    <h3><?= $t['admin_card_create_qcm_title'] ?></h3>
    <p><?= $t['admin_card_create_qcm_desc'] ?></p>
    <a href="index.php?page=admin&action=creer_qcm">
        <button class="admin-btn"><?= $t['admin_card_create_qcm_title'] ?></button>
    </a>
    </div>
    
    <div class="admin-card">
    <h3><?= $t['admin_card_users_title'] ?></h3>
    <p><?= $t['admin_card_users_desc'] ?></p>
    <a href="index.php?page=admin&action=voir_users">
        <button class="admin-btn"><?= $t['admin_card_users_title'] ?></button>
    </a>
    </div>

    <div class="admin-card">
    <h3><?= $t['admin_card_create_account_title'] ?></h3>
    <p><?= $t['admin_card_create_account_desc'] ?></p>
    <a href="index.php?page=admin&action=creer_compte">
        <button class="admin-btn"><?= $t['admin_card_create_account_title'] ?></button>
    </a>
    </div>
    
</div>