<?php
/**
 * @file en.php
 * Associative array containing the texts of the website in English.
 * 
 * @package DE-BUT
 */

$t = [
    
    'lang_fr' => 'French',
    'lang_en' => 'English',

    // -- Home page --
    'home_title' => 'Welcome to the DE-BUT platform!',
    'home_subtitle' => 'Get ready for your first year in IT Bachelor: Quizes, lessons, exercises.',
    'home_card_courses_title' => 'Lessons',
    'home_card_courses_text' => 'Access all lessons to revise efficiently.',
    'home_card_exercices_title' => 'Exercises',
    'home_card_exercices_text' => 'Practice with various exercises to progress quickly.',
    'home_card_qcm_title' => 'Quiz',
    'home_card_qcm_text' => 'Test your knowledge with interactive quizzes.',

    // --- Courses page ---
    'courses_title' => 'Courses',
    'courses_subtitle' => 'Search, discover, progress',
    'courses_search_placeholder' => 'Search a course, subject, author…',
    'courses_search_button' => 'Search',
    'courses_filter_button' => 'Filter',
    'courses_filter_title' => 'Filter courses',
    'courses_filter_level' => 'Level',
    'courses_filter_level_all'=>'All levels',
    'courses_filter_subject'=>'Subject',
    'courses_filter_subject_all'=>'All subjects',
    'courses_filter_cancel'=>'Cancel',
    'courses_filter_submit'=>'Show results',
    'courses_empty'=>'No course available yet.',
    'courses_by_author_prefix'=>'By ',
    'courses_label_subject'=>'Subject: ',
    'courses_label_level' => 'Level: ',
    'courses_label_description' => 'Description: ',
    'courses_view_button' => '▶ View course',
    'courses_action_sidebar' => 'Action',
    'course_status_completed' => 'Already seen',
    'course_status_not_completed' => 'Not seen yet',


    // --- Course view page ---
    'course_back'=>'Back',
    'course_author'=>'By ',
    'course_author_unknown'=>'unknown',
    'course_download'=>'Download document',

    // --- Course edit page ---
    'course_edit_msg_saved'=>'Changes saved.',
    'course_edit_label_title'=>'Title',
    'course_edit_label_description'=>'Description',
    'course_edit_label_level'=>'Level',
    'course_edit_label_subject'=>'Subject',
    'course_edit_label_author'=>'Author',
    'course_edit_label_file'=>'PDF file',
    'course_edit_label_published'=>'Published?',
    'course_edit_cancel'=>'Cancel',
    'course_edit_confirm'=>'Confirm',

    // --- Course reading page ---
    'course_back'=>'Back',
    'course_author'=>'Author: ',
    'course_author_unknown'=>'unknown',
    'course_download'=>'Download document',
    'course_status_completed_text'=>'This course is marked as completed:',
    'course_status_not_completed_text'=>'This course is not marked as completed yet:',
    'course_button_seen'=>'Mark as not completed',
    'course_button_not_seen'=>'Mark as completed',
    't_msg_saved'=>'Changes saved.',
    'course_marked_seen'=>'Course marked as completed.',
    'course_marked_unseen'=>'Course marked as not completed.',
    'course_marked_seen_message'=>'Course marked as completed.',
    'course_marked_unseen_message'=>'Course marked as not completed.',

    // --- QCM page ---
    'qcm_title'=>'Quizzes',
    'qcm_subtitle'=>'Test, learn, progress',
    'qcm_search_placeholder'=>'Search a quiz, subject…',
    'qcm_search_button'=>'Search',
    'qcm_filter_button'=>'Filter',
    'qcm_filter_title'=>'Filter quizzes',
    'qcm_filter_level'=>'Level',
    'qcm_filter_level_all'=>'All levels',
    'qcm_filter_subject'=>'Subject',
    'qcm_filter_subject_all'=>'All subjects',
    'qcm_filter_cancel'=>'Cancel',
    'qcm_filter_submit'=>'Show results',
    'qcm_empty'=>'No quiz available yet.',
    'qcm_label_subject'=>'Subject: ',
    'qcm_label_level'=>'Level: ',
    'qcm_start_button'=>'▶ Start quiz',
    'qcm_sidebar_progress'=>'Progress',

    // --- QCM run page ---
    'qcm_run_title'=>'Quiz',
    'qcm_run_subtitle'=>'Answer, validate to see the correction, then move on.',
    'qcm_run_question_prefix'=>'1. ',
    'qcm_run_button_result'=>'See result',
    'qcm_run_button_next'=>'Next question',
    'qcm_run_confirm_exit'=>'Are you sure you want to leave the quiz?',
    'qcm_run_back_to_list'=>'Back to quizzes',

    // --- QCM result page ---
    'qcm_result_title'=>'Results',
    'qcm_result_correct_suffix'=>'correct',
    'qcm_result_msg_perfect'=>'Perfect!',
    'qcm_result_msg_good'=>'Great level! You understood the expectations.',
    'qcm_result_msg_ok'=>'Not bad, you can redo this quiz to practise.',
    'qcm_result_msg_retry'=>'You can try this quiz again anytime.',
    'qcm_result_correct_answers'=>'Correct answer(s):',
    'qcm_result_your_answers'=>'Your answers:',
    'qcm_result_none'=>'None',
    'qcm_result_retry_this'=>'Retry this quiz',

    // --- QCM edit page ---
    'qcm_edit_msg_saved'=>'Changes saved.',
    'qcm_edit_title'=>'Quiz',
    'qcm_edit_label_title'=>'Title',
    'qcm_edit_label_level'=>'Level',
    'qcm_edit_label_subject'=>'Subject',
    'qcm_edit_questions_title'=>'Questions',
    'qcm_edit_label_statement'=>'Statement',
    'qcm_edit_cancel'=>'Cancel',
    'qcm_edit_confirm'=>'Confirm',

    // --- ADMIN PAGE: dashboard ---
    'admin_title'=>'Admin Area',
    'admin_card_courses_title'=>'View courses',
    'admin_card_courses_desc'=>'See all existing courses and manage their content',
    'admin_card_qcms_title'=>'View quizzes',
    'admin_card_qcms_desc'=>'See all existing quizzes and manage their content',
    'admin_card_create_course_title'=>'Create a course',
    'admin_card_create_course_desc'=>'Add a new course with a title, description and difficulty level',
    'admin_card_create_qcm_title'=>'Create a quiz',
    'admin_card_create_qcm_desc'=>'Create a questionnaire with questions and answer choices',
    'admin_card_users_title'=>'View users',
    'admin_card_users_desc'=>'See all accounts (admins and students)',
    'admin_card_create_account_title'=>'Create an account',
    'admin_card_create_account_desc'=>'Create a student or administrator account',

    // --- ADMIN: create course ---
    'admin_create_course_title'=>'Create a Course',
    'admin_create_course_step1'=>'1) Course information',
    'admin_create_course_label_title'=>'Title',
    'admin_create_course_label_level'=>'Level',
    'admin_create_course_label_subject'=>'Subject',
    'admin_create_course_label_author'=>'Author',
    'admin_create_course_label_description'=>'Description',
    'admin_create_course_step2'=>'2) File to upload',
    'admin_create_course_label_file'=>'PDF File',
    'admin_create_course_step3'=>'3) Create course',
    'admin_cancel'=>'Cancel',
    'admin_save_course'=>'Save course',

    // --- ADMIN: list courses ---
    'admin_list_courses_title'=>'Course list',
    'admin_no_courses'=>'No course available.',
    'admin_course_column_number'=>'#',
    'admin_course_column_title'=>'Title',
    'admin_course_column_description'=>'Description',
    'admin_course_column_level'=>'Level',
    'admin_course_column_subject'=>'Subject',
    'admin_course_column_author'=>'Author',
    'admin_course_column_actions'=>'Actions',
    'admin_course_view'=>'View course',
    'admin_edit'=>'Edit',
    'admin_publish'=>'Publish',
    'admin_unpublish'=>'Unpublish',
    'admin_delete'=>'Delete',
    'admin_confirm_delete_course'=>'Do you really want to delete this course?',
    'admin_back'=>'⬅ Back',

    // --- ADMIN: list QCMs ---
    'admin_list_qcms_title'=>'Quiz list',
    'admin_no_qcm'=>'No quiz available.',
    'admin_take_qcm'=>'Take quiz',
    'admin_confirm_delete_qcm'=>'Do you really want to delete this quiz?',

    // --- ADMIN: list users ---
    'admin_list_users_title'=>'User list',
    'admin_no_users'=>'No user found.',
    'admin_user_column_firstname'=>'First name',
    'admin_user_column_lastname'=>'Last name',
    'admin_user_column_email'=>'Email',
    'admin_user_column_role'=>'Role',
    'admin_user_activate'=>'Activate',
    'admin_user_deactivate'=>'Desactivate',
    'admin_confirm_delete_user'=>'Do you really want to delete this user?',

    // --- ADMIN: create QCM ---
    'admin_create_qcm_title'=>'Create a Quiz',
    'admin_create_qcm_step1'=>'1) Quiz Information',
    'admin_create_qcm_label_statement'=>'Question statement',
    'admin_create_qcm_add_question'=>'Add question',
    'admin_create_qcm_delete_question'=>'Delete question',
    'admin_create_qcm_step2'=>'2) Add questions',
    'admin_create_qcm_step3'=>'3) Create quiz',
    'admin_save_qcm'=>'Save quiz',

    // --- ADMIN: create account ---
    'admin_create_account_title'=>'Create an account',
    'admin_account_info'=>'Account information',
    'admin_label_firstname'=>'First name',
    'admin_label_lastname'=>'Last name',
    'admin_label_email'=>'Email',
    'admin_label_password'=>'Temporary password (optional)',
    'admin_label_role'=>'Role',
    'admin_role_student'=>'Student',
    'admin_role_director'=>'Director',
    'admin_role_admin'=>'Administrator',
    'admin_save_account'=>'Create account',

    // -- Header En --
    'nav_home' => 'Home',
    'nav_courses' => 'Courses',
    'nav_exercises' => 'Exercises',
    'nav_quiz' => 'Quiz',
    'nav_admin' => 'Admin',
    'nav_logout' => 'Logout',

];
?>