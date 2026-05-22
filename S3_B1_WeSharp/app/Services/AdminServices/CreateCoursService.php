<?php
declare(strict_types=1);

namespace App\Services\AdminServices;

use App\DAO\InterfacesDAO\ICoursDAO;
use App\Models\Contenu;
use App\Models\Cours;

/**
 * Service dedicated to creating courses
 */
class CreateCoursService
{
    #region Attributs
    private ICoursDAO $coursDao; // the cours dao
    #endregion
    
    #region Constructor
    /**
     * Initializes a CreateCoursService
     *
     * @param ICoursDAO $dao The cours dao
     */
    public function __construct(ICoursDAO $dao) 
    {
        $this->coursDao = $dao;
    }
    #endregion

    #region Method
    /**
     * Handles the creation of a new course from admin.
     *
     * @param array $input Form data ($_POST)
     * @return array [successMessage|null, errorsArray|null] An array containing the success message or the error messages
     */
    public function handle(array $input, array $files): array
    {
        $errors = [];
        $res = [null, null];

        $titre = trim($input['titre'] ?? '');
        $description = trim($input['description'] ?? '');
        $niveau = (int)($input['niveau'] ?? 0);
        $matiere = (int)($input['matiere'] ?? 0);
        $auteur = (int)($input['auteur'] ?? 0);

        // Validation
        if ($titre === '') $errors[] = "Le titre est requis.";
        if ($niveau <= 0) $errors[] = "Le niveau est requis.";
        if ($matiere <= 0) $errors[] = "La matière est requise.";

        if (empty($errors)) {
            // Upload file
            if (!isset($files['fichier']) || $files['fichier']['error'] !== 0) {
                $res = [null, ["Fichier manquant ou invalide."]];
                return $res;
            }

            $uploadName = uniqid() . '-' . basename($files['fichier']['name']);
            $targetPath = "../app/uploads/$uploadName";

            if (!file_exists("../app/uploads")) {
                mkdir("../app/uploads", 0777, true);
            }

            if (!move_uploaded_file($files['fichier']['tmp_name'], $targetPath)) {
                $res = [null, ["Erreur lors de l'upload du fichier."]];
                return $res;
            }

            // Creates the content
            $contenu = new Contenu(
                id: null,
                titre: $titre,
                niveau: $niveau,
                matiereId: $matiere,
                auteurId: $auteur,
                isPublished: false
            );

            // Creates the course with the content
            $cours = new Cours(
                id: null,
                fichier: $uploadName,
                contenu: $contenu,
                description: $description,
                matiere: null,
                auteur: null
            );

            // Saves the course
            $ok = $this->coursDao->create($cours);  
            
            if ($ok) {
                $res = ["Cours créé avec succès !", null];
            } else {
                $res = [null, ["Erreur lors de la création du cours."]];
            }
        } else {
            $res = [null, $errors];
        }

        return $res;
    }
    #endregion
}