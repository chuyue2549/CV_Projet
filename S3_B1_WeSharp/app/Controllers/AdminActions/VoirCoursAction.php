<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\ICoursDAO;

/**
 * Action that displays the courses
 */
class VoirCoursAction implements IPageAction
{
    #region Attributs
    private ICoursDAO $coursDAO; // the course dao
    #endregion

    #region Constructor
    /**
     * Initializes a VoirCoursAction
     *
     * @param ICoursDAO $coursDAO The course dao
     */
    public function __construct(ICoursDAO $coursDAO) 
    {
        $this->coursDAO = $coursDAO;
    }
    #endregion

    #region Method
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        $_SESSION['previous_cours_page'] = 'index.php?page=admin&action=voir_cours';

        return [
            'coursList' => $this->coursDAO->getAll(),
        ];
    }
    #endregion
}