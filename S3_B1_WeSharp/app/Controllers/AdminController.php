<?php
declare(strict_types=1);


namespace App\Controllers;

use App\DAO\CoursDAO;
use App\DAO\QcmDAO;
use App\DAO\MatieresDAO;
use App\DAO\UserCompteDAO;
use App\DAO\InterfacesDAO\ICoursDAO;
use App\Models\Cours;
use App\Models\Contenu;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Compte;
use App\Models\User;
use App\Services\MailService;
use App\DAO\InterfacesDAO\IQcmDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;
use App\DAO\InterfacesDAO\IUserCompteDAO;

// Actions
use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\Controllers\AdminActions\VoirCoursAction;
use App\Controllers\AdminActions\VoirQcmAction;
use App\Controllers\AdminActions\VoirUsersAction;
use App\Controllers\AdminActions\CreerCoursAction;
use App\Controllers\AdminActions\CreerQcmAction;
use App\Controllers\AdminActions\CreerCompteAction;
use App\Controllers\AdminActions\EditCoursAction;
use App\Controllers\AdminActions\UpdateCoursAction;
use App\Controllers\AdminActions\EditQcmAction;
use App\Controllers\AdminActions\UpdateQcmAction;
use App\Controllers\AdminActions\TogglePublicationCoursAction;
use App\Controllers\AdminActions\TogglePublicationQcmAction;
use App\Controllers\AdminActions\SupprimerCoursAction;
use App\Controllers\AdminActions\SupprimerQcmAction;
use App\Controllers\AdminActions\ToggleUserAction;
use App\Controllers\AdminActions\SupprimerUserAction;
use App\Controllers\AdminActions\ModifierRoleAction;

// Services
use App\Services\AdminServices\CreateCoursService;
use App\Services\AdminServices\CreateQcmService;
use App\Services\AdminServices\CreateCompteService;

/**
 * Responsible of displaying the right page and content in the administration page.
 */
class AdminController
{
    #region Attributs
    private ICoursDAO $coursDAO; // the course dao
    private IQcmDAO $qcmDAO; // the qcm dao
    private IMatieresDAO $matieresDAO; // the subject dao
    private IUserCompteDAO $userCompteDAO; // the user compte dao

    /** @var array<string, mixed> */
    private array $actions = [];
    #endregion

    #region Constructor
    /**
     * Initializes an AdminController
     *
     * @param ICoursDAO $coursDAO The course dao
     * @param IQcmDAO $qcmDAO The qcm dao
     * @param IMatieresDAO $matieresDAO The subject dao
     * @param IUserCompteDAO $userCompteDAO The user compte dao
     */
    public function __construct(ICoursDAO $coursDAO, IQcmDAO $qcmDAO, IMatieresDAO $matieresDAO, IUserCompteDAO $userCompteDAO) 
    {
        $this->coursDAO = $coursDAO;
        $this->qcmDAO = $qcmDAO;
        $this->matieresDAO = $matieresDAO;
        $this->userCompteDAO = $userCompteDAO;

        // Service instances
        $createCoursService = new CreateCoursService($this->coursDAO);
        $createQcmService = new CreateQcmService($this->qcmDAO);
        $createCompteService = new CreateCompteService($this->userCompteDAO);

        // Admin actions mapping
        $this->actions = [
            // Views pages
            'voir_cours' => new VoirCoursAction($this->coursDAO),
            'voir_qcm' => new VoirQcmAction($this->qcmDAO),
            'voir_users' => new VoirUsersAction($this->userCompteDAO),

            // Forms
            'creer_cours' => new CreerCoursAction($this->coursDAO, $this->matieresDAO, $createCoursService),
            'creer_qcm' => new CreerQcmAction($this->qcmDAO, $this->matieresDAO, $createQcmService),
            'creer_compte' => new CreerCompteAction($this->userCompteDAO, $createCompteService),
            'edit_cours'    => new EditCoursAction($this->coursDAO, $this->matieresDAO),
            'update_cours'  => new UpdateCoursAction($this->coursDAO),

            'edit_qcm'      => new EditQcmAction($this->qcmDAO, $this->matieresDAO),
            'update_qcm'    => new UpdateQcmAction($this->qcmDAO),

            // Actions (toggles / delete / update)
            'toggle_publication_cours' => new TogglePublicationCoursAction($this->coursDAO),
            'toggle_publication_qcm' => new TogglePublicationQcmAction($this->qcmDAO),
            'supprimer_cours' => new SupprimerCoursAction($this->coursDAO),
            'supprimer_qcm' => new SupprimerQcmAction($this->qcmDAO),
            'toggle_user' => new ToggleUserAction($this->userCompteDAO),
            'supprimer_user' => new SupprimerUserAction($this->userCompteDAO),
            'modifier_role' => new ModifierRoleAction($this->userCompteDAO),
        ];
    }
    #endregion

    #region Methods
    /**
     * Responsible for the display of the different pages in "admin" and its content.
     */
    public function adminPage(): void
    {
        $actionName = $_GET['action'] ?? null;

        // Récupération des messages de session
        $success = null;
        $errors  = [];

        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        if (!empty($_SESSION['error'])) {
            $errors = is_array($_SESSION['error']) ? $_SESSION['error'] : [$_SESSION['error']];
            unset($_SESSION['error']);
        }

        $data = [];

        if ($actionName !== null && isset($this->actions[$actionName])) {
            $action = $this->actions[$actionName];

            // If it's a IPageAction : array returned
            if ($action instanceof IPageAction) {
                $data = $action();

            } 
            // Else, it's a ICommandAction with nothing returned
            else {
                $action();
                return;
            }
        }

        // Error / success messages
        if (!array_key_exists('errors', $data)) {
            $data['errors'] = $errors;
        } elseif (!empty($errors)) {
            $data['errors'] = array_merge((array) $data['errors'], $errors);
        }

        if (!array_key_exists('success', $data)) {
            $data['success'] = $success;
        } elseif ($success !== null && $data['success'] === null) {
            $data['success'] = $success;
        }

        $data['action'] = $actionName ?? null;

        // Render the view with data (if there are data)
        extract($data);

        require __DIR__ . '/../views/pages/admin.php';
    }
    #endregion
}