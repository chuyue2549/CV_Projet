<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\IQcmDAO;

/**
 * Action that updates a qcm
 */
class UpdateQcmAction implements ICommandAction
{
    #region Attributs
    private IQcmDAO $dao; // the qcm dao
    #endregion

    #region Constructor
    /**
     * Initializes a UpdateQcmAction
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=admin&action=voir_qcm");
            exit;
        }

        $id = (int)$_POST['id'];
        $qcm = $this->dao->getById($id);

        if (!$qcm) {
            $_SESSION['error'][] = "QCM introuvable.";
            header("Location: index.php?page=admin&action=voir_qcm");
            exit;
        }

        $contenu = $qcm->getContenu();
        $contenu->setTitre($_POST['titre']);
        $contenu->setNiveau((int)$_POST['niveau']);
        $contenu->setMatiereId((int)$_POST['matiere']);

        $this->dao->update($qcm);

        foreach ($_POST['questions'] as $q) {
            $this->dao->updateQuestion((int)$q['id'], $q['enonce']);

            foreach ($q['reponses'] as $r) {
                $this->dao->updateReponse(
                    (int)$r['id'],
                    $r['texte'],
                    $r['is_correct'] == "1"
                );
            }
        }

        $_SESSION['success'] = "Le qcm a été modifié.";

        header("Location: index.php?page=admin&action=edit_qcm&id=$id&msg=ok");
        exit;
    }
    #endregion
}