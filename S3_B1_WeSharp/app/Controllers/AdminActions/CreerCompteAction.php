<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\Services\AdminServices\CreateCompteService;
use App\DAO\InterfacesDAO\IUserCompteDAO;

/**
 * Action that handles the creation of new user accounts
 */
class CreerCompteAction implements IPageAction
{
    #region Attributs
    private IUserCompteDAO $userCompteDAO; // The user compte dao
    private CreateCompteService $service; // The service that creates the account
    #endregion

    #region Constructor
    /**
     * Initializes a CreerCompteAction
     *
     * @param IUserCompteDAO $userCompteDAO The user compte dao
     * @param CreateCompteService $service The service that creates the account
     */
    public function __construct(IUserCompteDAO $userCompteDAO, CreateCompteService $service)
    {
        $this->userCompteDAO = $userCompteDAO;
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

            header("Location: index.php?page=admin&action=creer_compte");
            exit;
        }

        return [
            'errors'  => $errors,
            'success' => $success
        ];
    }
    #endregion
}