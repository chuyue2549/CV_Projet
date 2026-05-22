<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\IUserCompteDAO;

/**
 * Action that displays the users
 */
class VoirUsersAction implements IPageAction
{
    #region Attributs
    private IUserCompteDAO $dao; // the user compte dao
    #endregion

    #region Constructor
    /**
     * Initializes a VoirUsersAction
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
    public function __invoke(): array
    {
        return [
            'usersList' => $this->dao->getAll(),
        ];
    }
    #endregion
}