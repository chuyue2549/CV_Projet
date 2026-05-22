<?php
declare(strict_types=1);

namespace App\DAO;

use PDO;
use App\Database\DatabaseConnection;
use App\DAO\InterfacesDAO\IMatieresDAO;
use App\Models\Matiere;

/**
 * Interacts with the database to handle the subjects
 */
class MatieresDAO implements IMatieresDAO 
{
    #region Attributs
    private PDO $db; // the connection to the database
    #endregion

    #region Constructor
    /**
     * Initializes a MatieresDAO
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
    public function getMatieres(): array 
    {
        // Query
        $stmt = $this->db->query('SELECT * FROM matieres');

        // Fetch all rows
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert to Matiere objects
        $matieres = [];
        foreach ($rows as $row) {
            $matieres[] = new Matiere(
                id: (int)$row['id'],
                titre: $row['nom'], 
                description: $row['description']
            );
        }

        return $matieres;
    }
    #endregion
}