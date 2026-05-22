<?php
declare(strict_types=1);

namespace App\Database;
use PDO;

/**
 * Class responsible for the connection to the database
 */
class DatabaseConnection {

    #region Attributs
    private ?PDO $db = null; // connection to the database
    #endregion

    #region Constructor
    /**
     * Initializes a new database connection if none already exists.
     */
    public function __construct() {
        // Creates a database connection (PDO) if none already exists.
        if ($this->db === null) {
            try {
                // Reads the config.ini file
                $config = parse_ini_file(__DIR__ . '/../../config/config.ini', true);
                $db_config = $config['DATABASE'];
                $dsn = "mysql:host={$db_config['host']};dbname={$db_config['name']};charset=utf8";

                $this->db = new PDO($dsn, $db_config['user'], $db_config['password']);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                throw new PDOException("Database connection error:" . $e->getMessage());
            }
        }
    }
    #endregion

    #region Methods
    /**
     * Returns the connection to the database. 
     *
     * @return PDO The connection to the database
     */
    public function getDb() : PDO {
        return $this->db;
    }
    #endregion
}

?>