<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\IUserCompteDAO;

/**
 * Action that activates / desactivates an account
 */
class ToggleUserAction implements ICommandAction
{
    #region Attributs
    private IUserCompteDAO $dao; // the user compte dao
    #endregion

    #region Constructor
    /**
     * Initializes a ToogleUserAction
     *
     * @param IUserCompteDAO $dao The user compte dao
     */
    public function __construct(IUserCompteDAO $dao) 
    {
        $this->dao = $dao;
    }
    #endregion

    #region Method
    /**
     * @inheritDoc
     */
    public function __invoke(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($_SESSION['compte']['user_id'] === $id) {
            $_SESSION['error'][] = "Impossible de modifier votre propre compte.";
        } elseif ($id > 0 && $this->dao->toggleActive($id)) {
            $_SESSION['success'] = "Statut mis à jour.";
        } else {
            $_SESSION['error'][] = "Action impossible.";
        }

        header("Location: index.php?page=admin&action=voir_users");
        exit;
    }
    #endregion
}