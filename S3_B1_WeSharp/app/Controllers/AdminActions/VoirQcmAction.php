<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\IQcmDAO;

/**
 * Action that displays the qcms
 */
class VoirQcmAction implements IPageAction
{
    #region Attributs
    private IQcmDAO $qcmDAO; // the qcm dao
    #endregion

    #region Constructor
    /**
     * Initializes a VoirQcmAction
     *
     * @param IQcmDAO $qcmDAO
     */
    public function __construct(IQcmDAO $qcmDAO) 
    {
        $this->qcmDAO = $qcmDAO;
    }
    #endregion

    #region Method
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        $_SESSION['previous_qcm_page'] = 'index.php?page=admin&action=voir_qcm';

        return [
            'qcmList' => $this->qcmDAO->getAll(),
        ];
    }
    #endregion
}