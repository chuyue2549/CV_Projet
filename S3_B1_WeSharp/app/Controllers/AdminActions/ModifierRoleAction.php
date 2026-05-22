<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\IUserCompteDAO;

/**
 * Action that changes the role of a user
 */
class ModifierRoleAction implements ICommandAction
{
    #region Attributs
    private IUserCompteDAO $dao; // the user compte dao
    #endregion

    #region Constructor
    /**
     * Initializes a ModifierRoleAction
     *
     * @param IUserCompteDAO $dao
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=admin&action=voir_users");
            exit;
        }

        $id = (int)($_POST['user_id'] ?? 0);
        $role = $_POST['role'] ?? null;

        if ($id > 0 && $role !== null && $this->dao->updateRole($id, $role)) {
            $_SESSION['success'] = "Rôle mis à jour.";
        } else {
            $_SESSION['error'][] = "Impossible de modifier le rôle.";
        }

        header("Location: index.php?page=admin&action=voir_users");
        exit;
    }
    #endregion
}