<?php
require_once __DIR__ . '/../../lang/init_lang.php';
?>

<!-- Account creation page -->
<div class="page-cree">

  <div class="background-bottom background-bottom-qcm"></div>

  <section class="create-course-wrapper">
    <form action="index.php?page=admin&action=creer_compte" method="post" id="compteForm">

      <h2 class="subtitle-admin"><?= $t['admin_create_account_title'] ?></h2>

      <div class="course-section">
        <h2><?= $t['admin_account_info'] ?></h2>

        <div class="form-group">
          <label for="prenom"><?= $t['admin_label_firstname'] ?></label>
          <input type="text" id="prenom" name="prenom" required placeholder="Ex : Anita">
        </div>

        <div class="form-group">
          <label for="nom"><?= $t['admin_label_lastname'] ?></label>
          <input type="text" id="nom" name="nom" required placeholder="Ex : Kunt">
        </div>

        <div class="form-group">
          <label for="email"><?= $t['admin_label_email'] ?></label>
          <input type="text" id="email" name="email" required placeholder="Ex : anita.kunt@wesharp.fr">
        </div>

        <div class="form-group">
          <label for="role"><?= $t['admin_label_role'] ?></label>
          <select name="role" id="role" required>
            <option value="etudiant"><?= $t['admin_role_student'] ?></option>
            <option value="directeur"><?= $t['admin_role_director'] ?></option>
            <option value="admin"><?= $t['admin_role_admin'] ?></option>
          </select>
        </div>

        <div class="course-actions">
          <a href="index.php?page=admin" class="btn-secondary"><?= $t['admin_cancel'] ?></a>
          <button type="submit" name="submit" class="btn-primary"><?= $t['admin_save_account'] ?></button>
        </div>
      </div>
    </form>
  </section>
</div>