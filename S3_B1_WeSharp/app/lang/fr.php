<?php
/**
 * @file fr.php
 * Associative array containing the texts of the website in French.
 * 
 * @package DE-BUT
 */

$t = [

    'lang_fr' => 'French',
    'lang_en' => 'English',

    // -- Page accueil --
    'home_title'  => 'Bienvenue sur la plateforme DE-BUT !',
    'home_subtitle' => 'Prépare ta première année en BUT Informatique : QCM, cours, exercices.',
    'home_card_courses_title' => 'Cours',
    'home_card_courses_text' => 'Accède à tous les cours pour réviser efficacement.',
    'home_card_exercices_title' => 'Exercices',
    'home_card_exercices_text' => 'Pratique avec des exercices variés pour progresser rapidement.',
    'home_card_qcm_title' => 'QCM',
    'home_card_qcm_text' => 'Teste tes connaissances avec des questionnaires interactifs.',

    // --- Page cours ---
    'courses_title' => 'Cours',
    'courses_subtitle' => 'Cherche, découvre, progresse',
    'courses_search_placeholder' => 'Rechercher un cours, une matière, un auteur…',
    'courses_search_button' => 'Recherche',
    'courses_filter_button' => 'Filtrer',
    'courses_filter_title' => 'Filtrer les cours',
    'courses_filter_level' => 'Niveau',
    'courses_filter_level_all' => 'Tous les niveaux',
    'courses_filter_subject' => 'Matière',
    'courses_filter_subject_all' => 'Toutes les matières',
    'courses_filter_cancel' => 'Annuler',
    'courses_filter_submit' => 'Afficher les résultats',
    'courses_empty' => 'Aucun cours disponible pour l\'instant.',
    'courses_by_author_prefix' => 'Par ',
    'courses_label_subject' => 'Matière : ',
    'courses_label_level' => 'Niveau : ',
    'courses_label_description' => 'Description : ',
    'courses_view_button' => '▶ Voir le cours',
    'courses_action_sidebar' => 'Action',
    'course_status_completed'=> 'Déjà vu',
    'course_status_not_completed' =>'Pas encore vu',

    // --- Course view page ---
    'course_back'=>'Retour',
    'course_author'=>'Auteur : ',
    'course_author_unknown'=>'inconnu',
    'course_download'=>'Télécharger le document',

    // --- Course edit page ---
    'course_edit_msg_saved'=>'Modifications enregistrées.',
    'course_edit_label_title'=>'Titre',
    'course_edit_label_description'=>'Description',
    'course_edit_label_level'=>'Niveau',
    'course_edit_label_subject'=>'Matière',
    'course_edit_label_author'=>'Auteur',
    'course_edit_label_file'=>'Fichier PDF',
    'course_edit_label_published'=>'Publié ?',
    'course_edit_cancel'=>'Annuler',
    'course_edit_confirm'=>'Confirmer',

    // --- Page lecture d'un cours ---
    'course_back'=>'Retour',
    'course_author'=>'Auteur : ',
    'course_author_unknown'=>'inconnu',
    'course_download'=>'Télécharger le document',
    'course_status_completed_text'=>'Ce cours est marqué comme vu :',
    'course_status_not_completed_text'=>'Ce cours n\'est pas encore marqué comme vu :',
    'course_button_seen'=>'Marquer comme non vu',
    'course_button_not_seen'=>'Marquer comme vu',
    't_msg_saved'=>'Modifications enregistrées.',
    'course_marked_seen'=>'Cours marqué comme vu.',
    'course_marked_unseen'=>'Cours marqué comme non vu.',
    'course_marked_seen_message'=>'Cours marqué comme vu.',
    'course_marked_unseen_message'=>'Cours marqué comme non vu.',

    // --- Page QCM ---
   'qcm_title'=>'QCM',
   'qcm_subtitle'=>'Teste, apprends, progresse',
   'qcm_search_placeholder'=>'Rechercher un QCM, une matière…',
   'qcm_search_button'=>'Recherche',
   'qcm_filter_button'=>'Filtrer',
   'qcm_filter_title'=>'Filtrer les QCM',
   'qcm_filter_level'=>'Niveau',
   'qcm_filter_level_all'=>'Tous les niveaux',
   'qcm_filter_subject'=>'Matière',
   'qcm_filter_subject_all'=>'Toutes les matières',
   'qcm_filter_cancel'=>'Annuler',
   'qcm_filter_submit'=>'Afficher les résultats',
   'qcm_empty'=>'Aucun QCM disponible pour le moment.',
   'qcm_label_subject'=>'Matière : ',
   'qcm_label_level'=>'Niveau : ',
   'qcm_start_button'=>'▶ Commencer le quiz',
   'qcm_sidebar_progress'=>'Avancement',

    // --- QCM run page ---
    'qcm_run_title'=>'QCM',
    'qcm_run_subtitle'=>'Répondez, validez pour voir la correction, puis passez à la suite.',
    'qcm_run_question_prefix'=>'1. ',
    'qcm_run_button_result'=>'Voir le résultat',
    'qcm_run_button_next'=>'Question suivante',
    'qcm_run_confirm_exit'=>'Êtes-vous sûr de quitter le QCM ?',
    'qcm_run_back_to_list'=>'Retour aux QCM',

    // --- QCM result page ---
    'qcm_result_title'=>'Résultats',
    'qcm_result_correct_suffix'=>'correct(s)',
    'qcm_result_msg_perfect'=>'Parfait !',
    'qcm_result_msg_good'=>'Très bon niveau ! Tu as bien compris les attentes.',
    'qcm_result_msg_ok'=>'Pas mal, tu peux refaire ce QCM pour t\'entraîner.',
    'qcm_result_msg_retry'=>'Tu peux retenter le quiz à tout moment.',
    'qcm_result_correct_answers'=>'Bonne(s) réponse(s) :',
    'qcm_result_your_answers'=>'Tes réponses :',
    'qcm_result_none'=>'Aucune',
    'qcm_result_retry_this'=>'Refaire ce QCM',

    // --- QCM edit page ---
    'qcm_edit_msg_saved'=>'Modifications enregistrées.',
    'qcm_edit_title'=>'QCM',
    'qcm_edit_label_title'=>'Titre',
    'qcm_edit_label_level'=>'Niveau',
    'qcm_edit_label_subject'=>'Matière',
    'qcm_edit_questions_title'=>'Questions',
    'qcm_edit_label_statement'=>'Énoncé',
    'qcm_edit_cancel'=>'Annuler',
    'qcm_edit_confirm'=>'Confirmer',

    // --- ADMIN PAGE: dashboard ---
    'admin_title'=>'Espace Administrateur',
    'admin_card_courses_title'=>'Voir les cours',
    'admin_card_courses_desc'=>'Consultez tous les cours existants et gérez leur contenu',
    'admin_card_qcms_title'=>'Voir les QCMs',
    'admin_card_qcms_desc'=>'Consultez tous les QCMs existants et gérez leur contenu',
    'admin_card_create_course_title'=>'Créer un cours',
    'admin_card_create_course_desc'=>'Ajoutez un nouveau cours avec un titre, une description et le niveau de difficulté',
    'admin_card_create_qcm_title'=>'Créer un QCM',
    'admin_card_create_qcm_desc'=>'Créez un questionnaire avec des questions et choix de réponses',
    'admin_card_users_title'=>'Voir les utilisateurs',
    'admin_card_users_desc'=>'Consultez tous les comptes (admins et élèves)',
    'admin_card_create_account_title'=>'Créer un compte',
    'admin_card_create_account_desc'=>'Créez un compte étudiant, administrateur...',

    // --- ADMIN: create course ---
    'admin_create_course_title'=>'Créer un Cours',
    'admin_create_course_step1'=>'1) Infos du cours',
    'admin_create_course_label_title'=>'Titre',
    'admin_create_course_label_level'=>'Niveau',
    'admin_create_course_label_subject'=>'Matière',
    'admin_create_course_label_author'=>'Auteur',
    'admin_create_course_label_description'=>'Description',
    'admin_create_course_step2'=>'2) Fichier à importer',
    'admin_create_course_label_file'=>'Fichier PDF',
    'admin_create_course_step3'=>'3) Créer le cours',
    'admin_cancel'=>'Annuler',
    'admin_save_course'=>'Enregistrer le cours',

    // --- ADMIN: list courses ---
    'admin_list_courses_title'=>'Liste des cours',
    'admin_no_courses'=>'Aucun cours disponible.',
    'admin_course_column_number'=>'n°',
    'admin_course_column_title'=>'Titre',
    'admin_course_column_description'=>'Description',
    'admin_course_column_level'=>'Niveau',
    'admin_course_column_subject'=>'Matière',
    'admin_course_column_author'=>'Auteur',
    'admin_course_column_actions'=>'Actions',
    'admin_course_view'=>'Voir le cours',
    'admin_edit'=>'Modifier',
    'admin_publish'=>'Publier',
    'admin_unpublish'=>'Dépublier',
    'admin_delete'=>'Supprimer',
    'admin_confirm_delete_course'=>'Voulez-vous vraiment supprimer ce cours ?',
    'admin_back'=>'⬅ Retour',

    // --- ADMIN: list QCMs ---
    'admin_list_qcms_title'=>'Liste des QCMs',
    'admin_no_qcm'=>'Aucun QCM disponible.',
    'admin_take_qcm'=>'Faire le QCM',
    'admin_confirm_delete_qcm'=>'Voulez-vous vraiment supprimer ce QCM ?',

    // --- ADMIN: list users ---
    'admin_list_users_title'=>'Liste des utilisateurs',
    'admin_no_users'=>'Aucun utilisateur trouvé.',
    'admin_user_column_firstname'=>'Prénom',
    'admin_user_column_lastname'=>'Nom',
    'admin_user_column_email'=>'Email',
    'admin_user_column_role'=>'Rôle',
    'admin_user_activate'=>'Activer',
    'admin_user_deactivate'=>'Désactiver',
    'admin_confirm_delete_user'=>'Voulez-vous vraiment supprimer cet utilisateur ?',

    // --- ADMIN: create QCM ---
    'admin_create_qcm_title'=>'Créer un QCM',
    'admin_create_qcm_step1'=>'1) Infos du QCM',
    'admin_create_qcm_label_statement'=>'Énoncé de la question',
    'admin_create_qcm_add_question'=>'Ajouter une question',
    'admin_create_qcm_delete_question'=>'Supprimer la question',
    'admin_create_qcm_step2'=>'2) Ajouter des questions',
    'admin_create_qcm_step3'=>'3) Créer le QCM',
    'admin_save_qcm'=>'Enregistrer le QCM',

    // --- ADMIN: create account ---
    'admin_create_account_title'=>'Créer un compte',
    'admin_account_info'=>'Infos du compte',
    'admin_label_firstname'=>'Prénom',
    'admin_label_lastname'=>'Nom',
    'admin_label_email'=>'Email',
    'admin_label_password'=>'Mot de passe provisoire (optionnel)',
    'admin_label_role'=>'Rôle',
    'admin_role_student'=>'Étudiant',
    'admin_role_director'=>'Directeur',
    'admin_role_admin'=>'Administrateur',
    'admin_save_account'=>'Créer le compte',

    // --- Header Fr ---
    'nav_home' => 'Accueil',
    'nav_courses' => 'Cours',
    'nav_exercises' => 'Exercices',
    'nav_quiz' => 'QCM',
    'nav_admin' => 'Admin',
    'nav_logout' => 'Déconnexion',

];
?>