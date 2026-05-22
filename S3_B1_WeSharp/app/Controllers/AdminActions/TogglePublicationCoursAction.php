<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\ICoursDAO;

/**
 * Action that publishes / unpublishes a course
 */
class TogglePublicationCoursAction implements ICommandAction
{
    #region Attributs
    private ICoursDAO $dao; // the course dao
    #endregion

    #region Constructor
    /**
     * Initializes a TogglePublicationCoursAction
     *
     * @param ICoursDAO $dao The course dao
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

        if ($id > 0 && $this->dao->togglePublication($id)) {
            $_SESSION['success'] = "L'état de publication a été modifié.";
        } else {
            $_SESSION['error'][] = "Impossible de modifier l'état.";
        }

        header("Location: index.php?page=admin&action=voir_cours");
        exit;
    }
    #endregion
}