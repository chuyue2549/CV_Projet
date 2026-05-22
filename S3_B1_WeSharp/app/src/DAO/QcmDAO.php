<?php
declare(strict_types=1);

namespace App\DAO;

use PDO;
use App\Database\DatabaseConnection;
use App\DAO\InterfacesDAO\IQcmDAO;
use App\Models\Contenu;
use App\Models\Qcm;
use App\Models\Question;
use App\Models\Reponse;

/**
 * Interacts with the database to handle the QCMs
 */
class QcmDAO implements IQcmDAO 
{
    #region Attributs
    private PDO $db; // the connection to the database
    #endregion

    #region Constructor
    /**
     * Initializes a QcmDAO
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
     * Builds a Qcm object from a database row
     * 
     * @param array $r The database row to create the qcm
     * @return Qcm The qcm created
     */
    private function buildQcm(array $r): Qcm
    {
        $contenu = new Contenu(
            id: (int)$r['contenuId'],
            titre: $r['titre'],
            niveau: (int)$r['niveau'],
            matiereId: (int)$r['matiereId'],
            auteurId: (int)$r['auteurId'],
            isPublished: (bool)$r['isPublished']
        );

        return new Qcm(
            id: (int)$r['id'],
            contenu: $contenu,
            matiere: $r['matiere']
        );
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array 
    {
        // Query
        $sql = "
            SELECT 
                qcms.id AS id,
                contenu.id AS contenuId,
                contenu.titre AS titre,
                contenu.niveau AS niveau,
                contenu.matiere_id AS matiereId,
                contenu.is_published AS isPublished,
                users.id AS auteurId,
                concat(users.prenom,' ',users.nom) AS auteur,
                matieres.nom AS matiere
            FROM qcms
            JOIN contenu ON contenu.id = qcms.contenu_id
            JOIN matieres ON matieres.id = contenu.matiere_id
            JOIN users ON users.id = contenu.auteur_id
            ORDER BY qcms.id ASC";

        // Preparation
        $stmt = $this->db->query($sql);

        // Execution
        // Gets every QCM, creates a new "Qcm" with its values and adds it to the array
        $liste = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $liste[] = $this->buildQcm($row);
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

        if (!empty($q)) {
            $where[] = "(contenu.titre LIKE :q
                    OR matieres.nom LIKE :q)";
            $params[':q'] = "%{$q}%";
        }

        if ($matiereId !== null) {
            $where[] = "contenu.matiere_id = :matiereId";
            $params[':matiereId'] = $matiereId;
        }

        if ($niveau !== null) {
            $where[] = "contenu.niveau = :niveau";
            $params[':niveau'] = $niveau;
        }

        $where[] = "contenu.is_published = 1";

        $sql = "
            SELECT
                qcms.id                      AS id,         
                contenu.id                   AS contenuId,
                contenu.titre                AS titre,
                contenu.niveau               AS niveau,
                contenu.matiere_id           AS matiereId,
                contenu.is_published         AS isPublished,
                matieres.nom                 AS matiere,
                users.id                     AS auteurId,
                CONCAT(users.prenom,' ',users.nom) AS auteur
            FROM qcms
                JOIN contenu ON contenu.id = qcms.contenu_id
                JOIN matieres ON matieres.id = contenu.matiere_id
                JOIN users ON users.id = contenu.auteur_id
        ";

        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY contenu.id DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $rows  = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $liste = [];
        foreach ($rows as $r) {
            $liste[] = $this->buildQcm($r);
        }

        return $liste;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Qcm 
    {
        $qcm = null;

        // Query
        $sql = "
            SELECT 
                qcms.id AS id,
                qcms.contenu_id AS contenuId,

                contenu.titre AS titre,
                contenu.niveau AS niveau,
                contenu.matiere_id AS matiereId,
                contenu.auteur_id AS auteurId,
                contenu.is_published AS isPublished,

                matieres.nom AS matiere,
                CONCAT(users.nom, ' ', users.prenom) AS auteur

            FROM qcms
            JOIN contenu ON contenu.id = qcms.contenu_id
            JOIN matieres ON contenu.matiere_id = matieres.id
            JOIN users ON contenu.auteur_id = users.id
            WHERE qcms.id = :id
            LIMIT 1";

        // Preparation
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        // Execution
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $qcm = $this->buildQcm($row);
        }

        return $qcm;
    }

    /**
     * @inheritDoc
     */
    public function getQuestions(int $qcmId): array 
    {
        // Query
        $query = "SELECT * FROM questions_qcm WHERE qcm_id = :qcmId";

        // Preparation
        $stmt = $this->db->prepare($query);

        // Execution
        $stmt->execute(['qcmId' => $qcmId]);

        // Results
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = new Question(
                id: (int)$row['id'],
                enonce: $row['enonce'],
                qcmId: (int)$row['qcm_id']
            );
        }
        
        return $questions;
    }

    /**
     * @inheritDoc
     */
    public function getReponses(int $questionId): array 
    {
        // Query
        $query = "SELECT * FROM reponses_qcm WHERE question_id = :questionId";

        // Preparation
        $stmt = $this->db->prepare($query);

        // Execution
        $stmt->execute(['questionId' => $questionId]);

        // Results
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $reponses = [];
        foreach ($rows as $row) {
            $reponses[] = new Reponse(
                id: (int)$row['id'],
                reponse: $row['reponse'],
                isCorrect: (bool)$row['is_correct'],
                questionId: (int)$row['question_id'],
                explications: $row['explications']
            );
        }

        return $reponses;
    }

    /**
     * @inheritDoc
     */
    public function createQcm(array $data): bool 
    {
        try {
            $this->db->beginTransaction();

            $contenu   = $data['contenu'];
            $questions = $data['questions'] ?? [];

            // Insert into contenu
            $sqlContenu = "INSERT INTO contenu (titre, niveau, matiere_id, auteur_id, is_published)
                           VALUES (:titre, :niveau, :matiereId, :auteurId, 1)";

            $stmt = $this->db->prepare($sqlContenu);
            $stmt->execute([
                'titre' => $contenu->getTitre(),
                'niveau' => $contenu->getNiveau(),
                'matiereId' => $contenu->getMatiereId(),
                'auteurId' => $contenu->getAuteurId()
            ]);

            $contenuId = (int)$this->db->lastInsertId();

            // Insert into qcms
            $sqlQcm = "INSERT INTO qcms (contenu_id) VALUES (:id)";
            $stmt = $this->db->prepare($sqlQcm);
            $stmt->execute(['id' => $contenuId]);

            $qcmId = (int)$this->db->lastInsertId();

            // Insert questions and answers
            foreach ($questions as $q) {

                // Insert question
                $sql = "INSERT INTO questions_qcm (qcm_id, enonce) VALUES (:qcm, :enonce)";

                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'qcm' => $qcmId,
                    'enonce' => $q->getEnonce()
                ]);

                $questionId = (int)$this->db->lastInsertId();

                // Insert answers
                $reponses = $q->getReponses();
                foreach ($reponses as $r) {

                    $sqlR = "INSERT INTO reponses_qcm (question_id, reponse, is_correct) VALUES (:questionId, :reponse, :isCorrect)";

                    $stmt = $this->db->prepare($sqlR);
                    $stmt->execute([
                        'questionId' => $questionId,
                        'reponse' => $r->getReponse(),
                        'isCorrect' => $r->isCorrect() ? 1 : 0
                    ]);
                }
            }

            // Commits the transaction
            $this->db->commit();
            return true;

        } 
        catch (\Throwable $e) {
            // Rolls back in case of error
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteQcm(int $id): bool
    {
        try {
            $this->db->beginTransaction();

            // Gets the id of the content associated to the qcm
            $sqlSelect = "
                SELECT qcms.contenu_id AS contenuId
                FROM qcms
                WHERE qcms.id = :id
            ";

            $stmt = $this->db->prepare($sqlSelect);
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $contenuId = (int)$row['contenuId'];

                // Gets every questions of the qcm
                $sqlQuestions = "SELECT id FROM questions_qcm WHERE qcm_id = :id";
                $stmt = $this->db->prepare($sqlQuestions);
                $stmt->execute(['id' => $id]);
                $questions = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // Deletes the questions
                if (!empty($questions)) {
                    $sqlDeleteReponses = "DELETE FROM reponses_qcm WHERE question_id IN (" . implode(",", $questions) . ")";
                    $this->db->exec($sqlDeleteReponses);
                }

                // Deletes the answers
                $sqlDeleteQuestions = "DELETE FROM questions_qcm WHERE qcm_id = :id";
                $stmt = $this->db->prepare($sqlDeleteQuestions);
                $stmt->execute(['id' => $id]);

                // Deletes the qcm
                $sqlDeleteQcm = "DELETE FROM qcms WHERE id = :id";
                $stmt = $this->db->prepare($sqlDeleteQcm);
                $stmt->execute(['id' => $id]);

                // Deletes the content
                $sqlDeleteContenu = "DELETE FROM contenu WHERE id = :cId";
                $stmt = $this->db->prepare($sqlDeleteContenu);
                $stmt->execute(['cId' => $contenuId]);

                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }

        } catch (\Throwable $e) {
            $this->db->rollBack();
            return false;
        }
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
    public function togglePublication(int $id): bool 
    {
        $sql = "
            UPDATE contenu 
            SET is_published = NOT is_published
            WHERE id = (SELECT contenu_id FROM qcms WHERE id = :id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function update(Qcm $q): bool
    {
        try {
            $this->db->beginTransaction();

            $c = $q->getContenu();

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
                'titre'   => $c->getTitre(),
                'niveau'  => $c->getNiveau(),
                'auteur'  => $c->getAuteurId(),
                'matiere' => $c->getMatiereId(),
                'pub'     => $c->isPublished(),
                'id'      => $c->getId()
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
    public function updateQuestion(int $id, string $enonce): bool
    {
        $sql = "
            UPDATE questions_qcm
            SET enonce = :enonce
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'enonce' => $enonce,
            'id'     => $id
        ]);
    }

    /**
     * @inheritDoc
     */
    public function updateReponse(int $id, string $texte, bool $correct): bool
    {
        $sql = "
            UPDATE reponses_qcm
            SET reponse = :texte,
                is_correct = :correct
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'texte'   => $texte,
            'correct' => $correct ? 1 : 0,
            'id'      => $id
        ]);
    }
    #endregion
}