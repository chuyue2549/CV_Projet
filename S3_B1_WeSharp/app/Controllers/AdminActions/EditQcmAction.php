<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\IPageAction;
use App\DAO\InterfacesDAO\IQcmDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;

/**
 * Action that edits a qcm
 */
class EditQcmAction implements IPageAction
{
    #region Attributs
    private IQcmDAO $qcmDAO; // the qcm dao 
    private IMatieresDAO $matieresDAO; // the matieres dao
    #endregion

    #region Constructor
    /**
     * Initializes a EditQcmAction
     *
     * @param IQcmDAO $qcmDAO The qcm dao
     * @param IMatieresDAO $matieresDAO The matieres dao
     */
    public function __construct(IQcmDAO $qcmDAO, IMatieresDAO $matieresDAO)
    {
        $this->qcmDAO = $qcmDAO;
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
        $qcm = $this->qcmDAO->getById($id);

        if (!$qcm) {
            $_SESSION['error'][] = "QCM introuvable.";
            header("Location: index.php?page=admin&action=voir_qcm");
            exit;
        }

        $questions = $this->qcmDAO->getQuestions($id);

        foreach ($questions as $q) {
            $q->setReponses($this->qcmDAO->getReponses($q->getId()));
        }

        return [
            'qcm'       => $qcm,
            'questions' => $questions,
            'matieres'  => $this->matieresDAO->getMatieres(),
            'success'   => null,
            'errors'    => []
        ];
    }
    #endregion
}