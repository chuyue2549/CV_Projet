<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\ICoursDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;

/**
 * Action that edits a course
 */
class EditCoursAction implements IPageAction
{
    #region Attributs
    private ICoursDAO $coursDAO; // the cours dao
    private IMatieresDAO $matieresDAO; // the matieres dao
    #endregion

    #region Constructor
    /**
     * Initializes a EditCoursAction
     *
     * @param ICoursDAO $coursDAO
     * @param IMatieresDAO $matieresDAO
     */
    public function __construct(ICoursDAO $coursDAO, IMatieresDAO $matieresDAO)
    {
        $this->coursDAO = $coursDAO;
        $this->matieresDAO = $matieresDAO;
    }
    #endregion

    #region Method
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        $id = (int)($_GET['id'] ?? 0);
        $cours = $this->coursDAO->getById($id);

        if (!$cours) {
            $_SESSION['error'][] = "Cours introuvable.";
            header("Location: index.php?page=admin&action=voir_cours");
            exit;
        }

        $matieres = $this->matieresDAO->getMatieres();
        $auteurs = $this->coursDAO->getAuteurs();

        return [
            'cours'    => $cours,
            'matieres' => $matieres,
            'auteurs'  => $auteurs,
            'success'  => null,
            'errors'   => []
        ];
    }
    #endregion
}