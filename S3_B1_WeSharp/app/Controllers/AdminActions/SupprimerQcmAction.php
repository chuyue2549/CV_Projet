<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\IQcmDAO;

/**
 * Action that deletes a qcm
 */
class SupprimerQcmAction implements ICommandAction
{
    #region Attributs
    private IQcmDAO $dao; // the qcm dao
    #endregion

    #region Constructor
    /**
     * Initializes a SupprimerQcmAction
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

        if ($id > 0 && $this->dao->deleteQcm($id)) {
            $_SESSION['success'] = "QCM supprimé.";
        } else {
            $_SESSION['error'][] = "Suppression impossible.";
        }

        header("Location: index.php?page=admin&action=voir_qcm");
        exit;
    }
    #endregion
}