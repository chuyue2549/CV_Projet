<?php
declare(strict_types=1);

namespace App\DAO;

use PDO;
use App\Models\Contenu;
use App\DAO\InterfacesDAO\IContenuDAO;

/**
 * Interacts with the database to handle the common content entity
 */
class ContenuDAO implements IContenuDAO
{
    #region Attributs
    private PDO $db; // the connection to the database
    #endregion

    #region Constructor
    /**
     * Initializes a ContenuDAO
     *
     * @param PDO $db The connection to the database
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    #endregion

    #region Methods

    /**
     * @inheritDoc
     */
    public function create(Contenu $contenu): int
    {
        // SQL Query
        $sql = "INSERT INTO contenu (titre, niveau, matiere_id, auteur_id, is_published)
                VALUES (:titre, :niveau, :matiereId, :auteurId, :isPublished)";

        // Preparation
        $stmt = $this->db->prepare($sql);

        // Execution
        $stmt->execute([
            'titre' => $contenu->getTitre(),
            'niveau' => $contenu->getNiveau(),
            'matiereId' => $contenu->getMatiereId(),
            'auteurId' => $contenu->getAuteurId(),
            'isPublished' => (int)$contenu->isPublished()
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Contenu
    {
        $cours = null;

        // SQL query
        $sql = "SELECT 
                    contenu.id AS id,
                    contenu.titre AS titre,
                    contenu.niveau AS niveau,
                    contenu.matiere_id AS matiereId,
                    matieres.nom AS matiere,
                    contenu.auteur_id AS auteurId,
                    CONCAT(users.prenom,' ',users.nom) AS auteur,
                    contenu.is_published AS isPublished
                FROM contenu
                JOIN matieres ON contenu.matiere_id = matieres.id
                JOIN users ON contenu.auteur_id = users.id
                WHERE contenu.id = :id";

        // Preparation
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        // Fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $contenu = new Contenu(
                id: (int)$row['id'],
                titre: $row['titre'],
                niveau: (int)$row['niveau'],
                matiereId: (int)$row['matiereId'],
                matiere: $row['matiere'],
                auteurId: (int)$row['auteurId'],
                auteur: $row['auteur'],
                isPublished: (bool)$row['isPublished']
            );
        }

        return $contenu;
    }

    #endregion
}