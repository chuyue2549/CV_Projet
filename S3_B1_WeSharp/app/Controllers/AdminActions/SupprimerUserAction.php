<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\IUserCompteDAO;

/**
 * Action that deletes a user
 */
class SupprimerUserAction implements ICommandAction
{
    #region Attributs
    private IUserCompteDAO $dao; // the user compte dao
    #endregion

    #region Constructor
    /**
     * Initializes a SupprimerUserAction
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

        if ($id === $_SESSION['compte']['user_id']) {
            $_SESSION['error'][] = "Vous ne pouvez pas supprimer votre propre compte.";
        } elseif ($this->dao->deleteUser($id)) {
            $_SESSION['success'] = "Utilisateur supprimé.";
        } else {
            $_SESSION['error'][] = "Impossible de supprimer.";
        }

        header("Location: index.php?page=admin&action=voir_users");
        exit;
    }
    #endregion
}