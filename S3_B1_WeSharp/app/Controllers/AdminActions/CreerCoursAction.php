<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\ICoursDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;
use App\Services\AdminServices\CreateCoursService;

/**
 * Action that creates a course
 */
class CreerCoursAction implements IPageAction
{
    #region Attributs
    private ICoursDAO $coursDAO; // The courses dao
    private IMatieresDAO $matieresDAO; // The subjects dao
    private CreateCoursService $service; // The service CreateCours
    #endregion

    #region Constructor
    /**
     * Initializes a CreerCoursAction
     *
     * @param ICoursDAO $coursDAO The courses dao
     * @param IMatieresDAO $matieresDAO The subjects dao
     * @param CreateCoursService $service The service CreateCours
     */
    public function __construct(ICoursDAO $coursDAO, IMatieresDAO $matieresDAO, CreateCoursService $service) 
    {
        $this->coursDAO = $coursDAO;
        $this->matieresDAO = $matieresDAO;
        $this->service = $service;
    }
    #endregion

    #region Method
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        $errors = [];
        $success = null;

        $matieres = $this->matieresDAO->getMatieres();
        $auteurs = $this->coursDAO->getAuteurs();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Service returns errors / success
            [$success, $errors] = $this->service->handle($_POST, $_FILES);

            // Success message
            if ($success) {
                $_SESSION['success'] = $success;
            }

            // Error message(s)
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
            }

            header("Location: index.php?page=admin&action=creer_cours");
            exit;
        }

        return [
            'matieres' => $matieres,
            'auteurs' => $auteurs,
            'errors' => $errors,
            'success' => $success
        ];
    }
}