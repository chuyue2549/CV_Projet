<?php
declare(strict_types=1);

namespace App\Controllers\AdminActions;

use App\Controllers\AdminActions\Interfaces\ICommandAction;
use App\DAO\InterfacesDAO\ICoursDAO;
use App\Models\Cours;

/**
 * Action that updates a course
 */
class UpdateCoursAction implements ICommandAction
{
    #region Attributs
    private ICoursDAO $coursDAO;
    #endregion
    
    #region Constructor
    /**
     * Initializes a UpdateCoursAction
     *
     * @param ICoursDAO $coursDAO The course dao
     */
    public function __construct(ICoursDAO $coursDAO)
    {
        $this->coursDAO = $coursDAO;
    }

    #region Method
    /**
     * @inheritDoc
     */
    public function __invoke(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=admin&action=voir_cours");
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $old = $this->coursDAO->getById($id);

        if (!$old) {
            $_SESSION['error'][] = "Cours introuvable.";
            header("Location: index.php?page=admin&action=voir_cours");
            exit;
        }

        // upload file
        $newFilename = $old->getFichier();

        if (!empty($_FILES['fichier']['name'])) {
            $newFilename = time() . "_" . basename($_FILES['fichier']['name']);
            $target = __DIR__ . "/../../uploads/" . $newFilename;

            if (!move_uploaded_file($_FILES['fichier']['tmp_name'], $target)) {
                $_SESSION['error'][] = "Erreur lors de l'upload.";
                header("Location: index.php?page=admin&action=edit_cours&id=$id");
                exit;
            }
        }

        // update contenu
        $contenu = $old->getContenu();
        $contenu->setTitre($_POST['titre']);
        $contenu->setMatiereId((int)$_POST['matiere']);
        $contenu->setNiveau((int)$_POST['niveau']);
        $contenu->setAuteurId((int)$_POST['auteur']);
        $contenu->setIsPublished(isset($_POST['pub']));

        // new cours object
        $cours = new Cours(
            id: $old->getId(),
            fichier: $newFilename,
            contenu: $contenu,
            description: $_POST['description']
        );

        $ok = $this->coursDAO->update($cours);
        if ($ok) {
            $_SESSION['success'] = "Le cours a été modifié.";
            header("Location: index.php?page=admin&action=edit_cours&id=$id&msg=ok");
            exit;
        } else {
            $_SESSION['error'][] = "Action impossible.";
            exit;
        }
    }
    #endregion
}