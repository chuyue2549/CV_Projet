<?php
declare(strict_types=1);

namespace App\Controllers;

use App\DAO\QcmDAO;
use App\DAO\InterfacesDAO\IQcmDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;
use App\Database\DatabaseConnection;
use App\Models\Question;
use App\Models\Reponse;

/**
 * Controls all actions related to QCMs.
 */
class QcmController 
{
    #region Attributs
    private IQcmDAO $qcmDAO; // qcms dao
    private IMatieresDAO $matieresDAO; // DAO handling the subjects
    #endregion

    #region Constructor
    /**
     * Initializes the controller
     *
     * @param IQcmDAO $qcmDAO Instance of the qcm dao
     * @param IMatieresDAO $matieresDAO Instance of the subjects dao
     */
    public function __construct(IQcmDAO $qcmDAO, IMatieresDAO $matieresDAO) 
    {
        $this->qcmDAO = $qcmDAO;
        $this->matieresDAO = $matieresDAO;
    }
    #endregion

    #region Methods
    /**
     * Displays the list of all published QCMs.
     * 
     * @return void
     */
    public function afficherQcms(): void 
    {
        $_SESSION['previous_qcm_page'] = 'index.php?page=qcm';
        $qcms = $this->qcmDAO->getAll();
        require __DIR__ . '/../views/pages/qcm.php';
    }

    /**
     * Starts a quiz session for the QCM.
     * 
     * @param int $id The QCM ID to start.
     * @return void
     */
    public function start(int $id): void 
    {
        $qcm = $this->qcmDAO->getById($id);
        if (!$qcm) {
            http_response_code(404);
            echo "QCM not found.";
            return;
        }

        // Initializes the quiz session
        $_SESSION['quiz'] = [
            'qcm_id' => $id,
            'step' => 1,
            'answers' => []
        ];

        header("Location: index.php?page=qcm_questions");
        exit;
    }

    /**
     * Displays and manages each quiz question step by step.
     * Saves user answers in the session.
     * 
     * @return void
     */
    public function question(): void 
    {
        if (!isset($_SESSION['quiz'])) {
            echo "<p>No quiz in progress.</p><a href='index.php?page=qcm'>Back</a>";
            return;
        }

        $qcmId = $_SESSION['quiz']['qcm_id'];
        $step = $_SESSION['quiz']['step'];
        $qcm = $this->qcmDAO->getById($qcmId);
        $questions = $this->qcmDAO->getQuestions($qcmId);

        // Verification : If no more questions then go to results
        if ($step > count($questions)) {
            header("Location: index.php?page=qcm_result");
            exit;
        }

        // Save answer if submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentQuestion = $questions[$step - 1];
            $_SESSION['quiz']['answers'][$currentQuestion->getId()] = $_POST['reponses'] ?? [];
            $_SESSION['quiz']['step']++;
            header("Location: index.php?page=qcm_questions");
            exit;
        }

        // Load current question and answers
        $question = $questions[$step - 1];
        $reponses = $this->qcmDAO->getReponses($question->getId());

        // Checks if the questions is the last one
        $isLast = $step >= count($questions);

        require __DIR__ . '/../views/pages/qcm_questions.php';
    }

    /**
     * Calculates and displays the final quiz result.
     * 
     * @return void
     */
    public function result(): void 
    {
        $quiz = $_SESSION['quiz'] ?? null;
        if (!$quiz) {
            echo "<p>No quiz found.</p><a href='index.php?page=qcm'>Back</a>";
            return;
        }

        $id = $quiz['qcm_id'];
        $answers = $quiz['answers'] ?? [];
        $questions = $this->qcmDAO->getQuestions($id);

        $score = 0;
        $details = [];

        foreach ($questions as $q) {

            // Gets the answers of the question
            $reponses = $this->qcmDAO->getReponses($q->getId());

            // Correct answers
            $bonnes = [];
            foreach ($reponses as $r) {
                if ($r->isCorrect()) $bonnes[] = $r;
            }

            // Answers chosen
            $choisiesIds = $answers[$q->getId()] ?? [];
            $choisies = [];
            foreach ($reponses as $r) {
                if (in_array($r->getId(), $choisiesIds)) {
                    $choisies[] = $r;
                }
            }

            // Checks if every correct answer were checked
            $bonnesIds = array_map(fn($r) => $r->getId(), $bonnes);

            $correct = (
                !empty($choisies) &&                                 // if at least one answer was chosen
                count(array_diff($bonnesIds, $choisiesIds)) === 0 && // every correct answers were chosen
                count(array_diff($choisiesIds, $bonnesIds)) === 0    // no wrong answers chosen
            );

            if ($correct) $score++;

            // Adds the details of the question (question, chosen one, right ones, correct)
            $details[] = [
                'question' => $q,
                'choisies' => $choisies,
                'bonnes' => $bonnes,
                'correct' => $correct,
            ];
        }

        $total = count($questions);
        $pourcentage = $total > 0 ? round(($score / $total) * 100) : 0;

        unset($_SESSION['quiz']);

        require __DIR__ . '/../views/pages/qcm_result.php';
    }

    /**
     * Lists published qcms with optional filters (matière / niveau / q) :
     * Sends qcms meet the requrements to the view.
     * 
     * @return void
     */
    public function afficherListeQcmFiltres(): void
    {
        $q = isset($_GET['q']) && $_GET['q'] !== '' ? (string)$_GET['q'] : null;

        $matiereId = isset($_GET['matiere']) && $_GET['matiere'] !== '' ? (int)$_GET['matiere'] : null;

        $niveau = isset($_GET['niveau']) && $_GET['niveau'] !== '' ? (int)$_GET['niveau'] : null;

        $matieres = $this->matieresDAO->getMatieres();

        $niveaux  = $this->qcmDAO->getNiveaux(); 

        $qcms = $this->qcmDAO->getAllFiltered($q, $matiereId, $niveau);
        $_SESSION['previous_qcm_page'] = 'index.php?page=qcm';
        require __DIR__ . '/../views/pages/qcm.php';
    }
    #endregion
}
