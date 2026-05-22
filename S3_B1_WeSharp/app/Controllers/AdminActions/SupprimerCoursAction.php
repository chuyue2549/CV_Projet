<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\ICoursDAO;

/**
 * Action that deletes a course
 */
class SupprimerCoursAction implements ICommandAction
{
    #region Attributs
    private ICoursDAO $dao; // the cours dao
    #endregion

    #region Cosntructor
    /**
     * Initializes a SupprimerCoursAction
     *
     * @param ICoursDAO $dao The cours dao
     */
    public function __construct(ICoursDAO $dao) 
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

        if ($id > 0 && $this->dao->delete($id)) {
            $_SESSION['success'] = "Cours supprimé.";
        } else {
            $_SESSION['error'][] = "Suppression impossible.";
        }

        header("Location: index.php?page=admin&action=voir_cours");
        exit;
    }
    #endregion
}