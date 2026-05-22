<?php
declare(strict_types=1);

namespace App\DAO;

use PDO;
use App\DAO\InterfacesDAO\IEtudierCoursDAO;

/**
 * Interacts with the database to handle the relation
 * between users and courses (viewed / completed)
 */
class EtudierCoursDAO implements IEtudierCoursDAO
{
    #region Attributes
    private PDO $db; // the connection to the database
    #endregion

    #region Constructor
    /**
     * Initializes an EtudierCoursDAO
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
    public function getById(int $userId): array
    {
        $sql = "
            SELECT cours_id, is_completed
            FROM etudier_cours
            WHERE user_id = :userId
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[(int)$row['cours_id']] = (bool)$row['is_completed'];
        }

        return $result;
    }

    /**
     *   
     * @inheritDoc
     */
    public function toggleCompletion(int $userId, int $coursId): bool
    {
        $sql = "
            INSERT INTO etudier_cours (user_id, cours_id, is_completed)
            VALUES (:userId, :coursId, 1)
            ON DUPLICATE KEY UPDATE
                is_completed = 1 - is_completed
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'userId'  => $userId,
            'coursId' => $coursId
        ]);
    }
    #endregion
}
