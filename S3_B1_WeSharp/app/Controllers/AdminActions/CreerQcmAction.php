<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\IQcmDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;
use App\Services\AdminServices\CreateQcmService;

/**
 * Action that creates a qcm
 */
class CreerQcmAction implements IPageAction
{
    #region Attributs
    private IQcmDAO $qcmDAO; // the qcms dao
    private IMatieresDAO $matieresDAO; // the subjects dao
    private CreateQcmService $service; // the service that creates qcm
    #endregion

    #region Constructor
    /**
     * Initializes a CreerQcmAction
     *
     * @param IQcmDAO $qcmDAO The qcms dao
     * @param IMatieresDAO $matieresDAO The subjects dao
     * @param CreateQcmService $service The service that creates qcm
     */
    public function __construct(IQcmDAO $qcmDAO, IMatieresDAO $matieresDAO, CreateQcmService $service) 
    {
        $this->qcmDAO = $qcmDAO;
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Service returns errors / success
            [$success, $errors] = $this->service->handle($_POST);

            // Success message
            if ($success) {
                $_SESSION['success'] = $success;
            }

            // Error message(s)
            if (!empty($errors)) {
                $_SESSION['error'] = $errors;
            }

            header("Location: index.php?page=admin&action=creer_qcm");
            exit;
        }

        return [
            'matieres' => $matieres,
            'errors' => $errors,
            'success' => $success
        ];
    }
    #endregion
}