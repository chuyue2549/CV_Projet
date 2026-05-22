<?php
declare(strict_types=1);

namespace App\Controllers;

use App\DAO\CoursDAO;
use App\DAO\MatieresDAO;
use App\DAO\EtudierCoursDAO;
use App\DAO\InterfacesDAO\ICoursDAO;
use APp\DAO\InterfacesDAO\IMatieresDAO;
use APp\DAO\InterfacesDAO\IEtudierCoursDAO;
use App\Database\DatabaseConnection;
use App\Models\Cours;
use App\Models\Compte;


/**
 * Responsible of displaying the courses
 */
class CoursController 
{
    #region Attributs
    private ICoursDAO $coursDAO; // DAO handling the courses
    private IMatieresDAO $matieresDAO; // DAO handling the subjects
    private IEtudierCoursDAO $etudierCoursDAO; // DAO handling the completion status
    #endregion

    #region Contructor
    /**
     * Initializes a CoursController
     *
     * @param ICoursDAO $coursDAO Instance of the cours dao
     * @param IMatieresDAO $matieresDAO Instance of the subjects dao
     */
    public function __construct(ICoursDAO $coursDAO, IMatieresDAO $matieresDAO, IEtudierCoursDAO $etudierCoursDAO) 
    {
        $this->coursDAO = $coursDAO;
        $this->matieresDAO = $matieresDAO;
        $this->etudierCoursDAO = $etudierCoursDAO;
    }
    #endregion

    #region Methods
    /** 
     * Lists all the courses on the page "cours.php"
     * 
     * @return void
     */
    public function afficherListeCours(): void 
    {
        $cours = $this->coursDAO->getAll();
        require __DIR__ . '/../views/pages/cours.php';
    }

    /**
     * Lists the published courses on the page "cours.php"
     *
     * @return void
     */
    public function afficherListeCoursPublies(): void 
    {
        $cours = $this->coursDAO->getAllPublished();
        require __DIR__ . '/../views/pages/cours.php';
    }

    /**
     * Displays a course on the page "cours_lecture.php"
     *
     * @param integer $id The id of the course to display
     * @return void
     */
    public function afficherCours(?int $id): void 
    {
        if (!$id) 
        {
            header("Location: index.php?page=cours");
        }

        // Sets the previous page
        // Used to go back to the right previous page as it is used by "cours.php" and "admin.php"
        // (so the user is not brought in the admin area)
        if (!isset($_SESSION['previous_cours_page']) || $_SESSION['previous_cours_page'] === 'index.php?page=admin&action=voir_cours') {
            $_SESSION['previous_cours_page'] = 'index.php?page=cours';
        }

        // Gets the course to display
        $cours = $this->coursDAO->getById($id);
        if (!$cours) {
            http_response_code(404);
            echo "Cours introuvable.";
            return;
        }

        //Get userId
        $userId = (int)$_SESSION['compte']['user_id'];

        $message = null;
        $messageType = "nonvu";

        // If clicked on the toggle button
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_completion'])) {

            // Toggle the completion status in the database
            $this->etudierCoursDAO->toggleCompletion($userId, $id);

            // Read the updated state
            $completedMap   = $this->etudierCoursDAO->getById($userId);
            $newIsCompleted = $completedMap[$id] ?? false;

            //Set a message depending on the new state
            if ($newIsCompleted) {
                $messageKey  = 'course_marked_seen_message';
                $messageType = 'vu';
            } else {
                $messageKey  = 'course_marked_unseen_message';
                $messageType = 'nonvu';
            }
        }

        $completedMap = $this->etudierCoursDAO->getById($userId);
        $isCompleted  = $completedMap[$id] ?? false;

        // Redirects the user to the page where the course will be displayed
        require __DIR__ . '/../views/pages/cours_lecture.php';

        // Unsets the previous page
        unset($_SESSION['previous_page']);
    }

    /**
     * Lists published courses with optional filters (matière / niveau / q)
     * send course meet the requrements to the view.
     */
    public function afficherListeCoursFiltres(): void
    {
        $q = isset($_GET['q']) && $_GET['q'] !== '' ? (string)$_GET['q']: null;

        $matiereId = isset($_GET['matiere']) && $_GET['matiere'] !== '' ? (int)$_GET['matiere']: null;

        $niveau = isset($_GET['niveau']) && $_GET['niveau'] !== '' ? (int)$_GET['niveau']: null;

        $matieres = $this->matieresDAO->getMatieres();

        $niveaux = $this->coursDAO->getNiveaux();
        $matieres = $this->matieresDAO->getMatieres();

        $niveaux = $this->coursDAO->getNiveaux();

        $cours = $this->coursDAO->getAllFiltered(
            $q,
            $matiereId,
            $niveau,
        );


        $userId = (int)$_SESSION['compte']['user_id'];

        $completedMap = $this->etudierCoursDAO->getById($userId);

        require __DIR__ . '/../views/pages/cours.php';
    }
    #endregion
}
