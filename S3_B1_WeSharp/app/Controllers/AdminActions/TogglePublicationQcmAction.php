<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\IQcmDAO;

/**
 * Action that publishes / unpublishes a qcm
 */
class TogglePublicationQcmAction implements ICommandAction
{
    #region Attributs
    private IQcmDAO $dao; // the qcm dao
    #endregion

    #region Constructor
    /**
     * Initializes a TogglePublicationQcmAction
     *
     * @param IQcmDAO $dao The qcm dao
     */
    public function __construct(IQcmDAO $dao) 
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
            $_SESSION['success'] = "L'état du QCM a été modifié.";
        } else {
            $_SESSION['error'][] = "Impossible de modifier l'état.";
        }

        header("Location: index.php?page=admin&action=voir_qcm");
        exit;
    }
    #endregion
}