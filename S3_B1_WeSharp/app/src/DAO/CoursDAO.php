<?php
declare(strict_types=1);

namespace App\DAO;

use PDO;
use App\Models\Cours;
use App\Models\Contenu;
use App\Models\Auteur;
use App\DAO\InterfacesDAO\ICoursDAO;
use App\DAO\InterfacesDAO\IContenuDAO;

/**
 * Interacts with the database to handle the courses
 */
class CoursDAO implements ICoursDAO 
{
    #region Attributs
    private PDO $db; // the connection to the database
    private IContenuDAO $contenuDAO; // DAO handling content
    #endregion

    #region Constructor
    /**
     * Initializes a CoursDAO
     *
     * @param PDO $db The connection to the database
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->contenuDAO = new ContenuDAO($db);
    }
    #endregion

    #region Methods
    /**
     * Builds a Cours object from a database row
     * 
     * @param array $r The database row to create the course
     * @return Qcm The course created
     */
    private function buildCours(array $r): Cours
    {
        $contenu = new Contenu(
            id: (int)$r['contenuId'],
            titre: $r['titre'],
            niveau: (int)$r['niveau'],
            matiereId: (int)$r['matiereId'],
            auteurId: (int)$r['auteurId'],
            isPublished: (bool)$r['isPublished']
        );

        return new Cours(
            id: (int)$r['id'],
            fichier: $r['fichier'],
            contenu: $contenu,
            description: $r['description'],
            matiere: $r['matiere'],
            auteur: $r['auteur']
        );
    }

    /**
     * @inheritDoc
     */
    public function create(Cours $cours) : bool 
    {
        try {
            $this->db->beginTransaction();

            // Create content first
            $contenuId = $this->contenuDAO->create($cours->getContenu());

            // Insert into cours
            $sqlCours = "INSERT INTO cours (contenu_id, description, fichier)
                         VALUES (:contenuId, :description, :fichier)";

            $stmt = $this->db->prepare($sqlCours);
            $stmt->execute([
                'contenuId'   => $contenuId,
                'description' => $cours->getDescription(),
                'fichier'     => $cours->getFichier()
            ]);

            $this->db->commit();
            return true;

        } catch (\Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        try {
            $this->db->beginTransaction();

            // SQL query to get the course
            $sqlSelect = "
                SELECT 
                    cours.contenu_id AS contenuId,
                    cours.fichier AS fichier
                FROM cours
                WHERE cours.id = :id
            ";

            $stmt = $this->db->prepare($sqlSelect);
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $contenuId = (int)$row['contenuId'];
                $fichier = $row['fichier'];

                // Deletes the course
                $sqlDeleteCours = "DELETE FROM cours WHERE id = :id";
                $stmt = $this->db->prepare($sqlDeleteCours);
                $stmt->execute(['id' => $id]);

                // Deletes the content
                $sqlDeleteContenu = "DELETE FROM contenu WHERE id = :cId";
                $stmt = $this->db->prepare($sqlDeleteContenu);
                $stmt->execute(['cId' => $contenuId]);

                // The file path
                $filePath = __DIR__ . "/../../uploads/" . $fichier;

                // Deletes the file of the course
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();
            return true;

        } catch (\Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array 
    {
        $sql = "
        SELECT 
            cours.id AS id,
            cours.fichier AS fichier,
            cours.description AS description,

            contenu.id AS contenuId,
            contenu.titre AS titre,
            contenu.niveau AS niveau,
            contenu.matiere_id AS matiereId,
            contenu.is_published AS isPublished,

            matieres.nom AS matiere,
            users.id AS auteurId,
            CONCAT(users.prenom,' ',users.nom) AS auteur

        FROM cours
        JOIN contenu ON contenu.id = cours.contenu_id
        JOIN matieres ON contenu.matiere_id = matieres.id
        JOIN users ON contenu.auteur_id = users.id
        ORDER BY contenu.id ASC";

        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $liste = [];
        foreach ($rows as $r) {
            $liste[] = $this->buildCours($r);
        }

        return $liste;
    }

    /**
     * @inheritDoc
     */
    public function getAllPublished(): array 
    {
        $sql = "
        SELECT 
            cours.id AS id,
            cours.fichier AS fichier,
            cours.description AS description,

            contenu.id AS contenuId,
            contenu.titre AS titre,
            contenu.niveau AS niveau,
            contenu.matiere_id AS matiereId,
            contenu.is_published AS isPublished,

            matieres.nom AS matiere,
            users.id AS auteurId,
            CONCAT(users.prenom,' ',users.nom) AS auteur

        FROM cours
        JOIN contenu ON contenu.id = cours.contenu_id
        JOIN matieres ON contenu.matiere_id = matieres.id
        JOIN users ON contenu.auteur_id = users.id
        WHERE contenu.is_published = 1
        ORDER BY contenu.id ASC";

        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $liste = [];
        foreach ($rows as $r) {
            $liste[] = $this->buildCours($r);
        }

        return $liste;
    }

    /**
     * @inheritDoc
     */
    public function getAllFiltered(?string $q = null, ?int $matiereId = null, ?int $niveau = null): array
    {
        $where  = [];
        $params = [];

        // search with a string q 
        if (!empty($q)) {
            $where[] = "(contenu.titre LIKE :q 
                      OR cours.description LIKE :q
                      OR matieres.nom LIKE :q
                      OR CONCAT(users.prenom,' ',users.nom) LIKE :q)";
            $params[':q'] = "%$q%";
        }

        // filter with subject
        if ($matiereId !== null) {
            $where[] = "contenu.matiere_id = :matiereId";
            $params[':matiereId'] = $matiereId;
        }

        // filter with level
        if ($niveau !== null) {
            $where[] = "contenu.niveau = :niveau";
            $params[':niveau'] = $niveau;
        }

        // always show only published courses
        $where[] = "contenu.is_published = 1";

        // Base SQL
        $sql = "
        SELECT 
            cours.id AS id,
            cours.fichier AS fichier,
            cours.description AS description,

            contenu.id AS contenuId,
            contenu.titre AS titre,
            contenu.niveau AS niveau,
            contenu.matiere_id AS matiereId,
            contenu.is_published AS isPublished,

            matieres.nom AS matiere,
            users.id AS auteurId,
            CONCAT(users.prenom,' ',users.nom) AS auteur

        FROM cours
        JOIN contenu ON contenu.id = cours.contenu_id
        JOIN matieres ON contenu.matiere_id = matieres.id
        JOIN users ON contenu.auteur_id = users.id";

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY contenu.id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $liste = [];
        foreach ($rows as $r) {
            $liste[] = $this->buildCours($r);
        }

        return $liste;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id) : ?Cours
    {
        $sql = "
        SELECT 
            cours.id AS id,
            cours.fichier AS fichier,
            cours.description AS description,

            contenu.id AS contenuId,
            contenu.titre AS titre,
            contenu.niveau AS niveau,
            contenu.matiere_id AS matiereId,
            contenu.is_published AS isPublished,

            matieres.nom AS matiere,
            users.id AS auteurId,
            CONCAT(users.prenom,' ',users.nom) AS auteur

        FROM cours
        JOIN contenu ON contenu.id = cours.contenu_id
        JOIN matieres ON contenu.matiere_id = matieres.id
        JOIN users ON contenu.auteur_id = users.id
        WHERE cours.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->buildCours($row) : null;
    }

    /**
     * @inheritDoc
     */
    public function togglePublication(int $id): bool
    {
        $sql = "UPDATE contenu 
                SET is_published = 1 - is_published
                WHERE id = (SELECT contenu_id FROM cours WHERE id = :id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function getAuteurs(): array 
    {
        // Query
        $query = "SELECT * FROM users WHERE role != 'etudiant'";

        // Execution
        $stmt = $this->db->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $auteurs = [];
        foreach ($rows as $r) {
            $auteurs[] = new Auteur(
                id: $r['id'],
                nom: $r['nom'],
                prenom: $r['prenom']
            );
        }

        return $auteurs;
    }

    /**
     * @inheritDoc
     */
    public function getNiveaux(): array
    {
        // Query
        $sql = "SELECT DISTINCT niveau FROM contenu ORDER BY niveau ASC";
        
        // Execution
        $stmt = $this->db->query($sql);
        $niveau = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $niveau;
    }

    /**
     * @inheritDoc
     */
    public function update(Cours $c): bool
    {
        try {
            $this->db->beginTransaction();

            // update contenu
            $sql = "
                UPDATE contenu SET
                    titre = :titre,
                    niveau = :niveau,
                    auteur_id = :auteur,
                    matiere_id = :matiere,
                    is_published = :pub
                WHERE id = :id
            ";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'titre' => $c->getContenu()->getTitre(),
                'niveau'=> $c->getContenu()->getNiveau(),
                'auteur' => $c->getContenu()->getAuteurId(),
                'matiere' => $c->getContenu()->getMatiereId(),
                'pub' => $c->getContenu()->isPublished(),
                'id' => $c->getContenu()->getId()
            ]);

            // update cours
            $sql2 = "
                UPDATE cours SET
                    description = :desc,
                    fichier = :file
                WHERE id = :id
            ";

            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([
                'desc' => $c->getDescription(),
                'file' => $c->getFichier(),
                'id' => $c->getId()
            ]);

            $this->db->commit();
            return true;

        } catch (\Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }
    #endregion
}
