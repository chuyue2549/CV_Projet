<?php
declare(strict_types=1);

namespace App\DAO;

use PDO;
use DateTime;
use App\Database\DatabaseConnection;
use App\Models\Compte;
use App\Models\User;
use App\DAO\InterfacesDAO\IUserCompteDAO;

/**
 * Interacts with the database to handle the accounts
 */
class UserCompteDAO implements IUserCompteDAO
{
    #region Attributs
    private PDO $db; // the connection to the database
    #endregion

    #region Constructor
    /**
     * Initializes a UserDAO
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
    public function create(User $user, Compte $compte): int
    {
        try {
            $this->db->beginTransaction();

            // User creation
            $sqlUser = "INSERT INTO users (nom, prenom, role)
                        VALUES (:nom, :prenom, :role)";

            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getRole()
            ]);
            $userId = (int)$this->db->lastInsertId();

            // Account creation
            $sqlCompte = "INSERT INTO comptes (user_id, email, password_hash, created_at, is_active, language_code, activation_token)
                          VALUES (:userId, :email, :passwordHash, :createdAt, :isActive, :languageCode, :activationToken)";

            $stmtCompte = $this->db->prepare($sqlCompte);
            $stmtCompte->execute([
                'userId' => $userId,
                'email' => $compte->getEmail(),
                'passwordHash' => $compte->getPasswordHash(),
                'createdAt' => $compte->getCreatedAt()->format('Y-m-d H:i:s'),
                'isActive' => (int)$compte->isActive(),
                'languageCode' => $compte->getLanguage(),
                'activationToken' => $compte->getActivationToken()
            ]);

            $this->db->commit();
            return $userId;

        } catch (\Exception $e) {
            $this->db->rollBack();
            return 0;
        }
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email): ?Compte
    { 
        $compte = null;
        
        // SQL Query
        $sql = "SELECT * FROM comptes WHERE email = :email LIMIT 1";

        // Preparation
        $stmt = $this->db->prepare($sql);

        // Execution
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $compte = new Compte(
                id: (int)$row['id'],
                email: $row['email'],
                passwordHash: $row['password_hash'],
                createdAt: new \DateTime($row['created_at']),
                isActive: (bool)$row['is_active'],
                language: $row['language_code'],
                userId: (int)$row['user_id'],
                activationToken: $row['activation_token']
            );
        };

        return $compte;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $userId): ?array
    {
        $res = [];
        
        // SQL
        $sql = "SELECT u.*, c.email, c.password_hash, c.created_at, c.is_active, c.language_code 
                FROM users u
                JOIN comptes c ON c.user_id = u.id
                WHERE u.id = :id";

        // Preparation
        $stmt = $this->db->prepare($sql);

        // Execution
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $user = new User(
                id: (int)$row['id'],
                nom: $row['nom'],
                prenom: $row['prenom'],
                role: $row['role']
            );

            $compte = new Compte(
                id: (int)$row['id'],
                email: $row['email'],
                passwordHash: $row['password_hash'],
                createdAt: new \DateTime($row['created_at']),
                isActive: (bool)$row['is_active'],
                language: $row['language_code'],
                userId: (int)$row['id'],
                activationToken: $row['activation_token']
            );

            $res = ['user' => $user,
                    'compte' => $compte
            ];
        }

        return $res;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        // SQL
        $sql = "SELECT u.*, c.email, c.is_active 
                FROM users u
                JOIN comptes c ON c.user_id = u.id
                ORDER BY id";

        // Execution
        $stmt = $this->db->query($sql);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            $result[] = [
                'user' => new User(
                    id: (int)$row['id'],
                    nom: $row['nom'],
                    prenom: $row['prenom'],
                    role: $row['role']
                ),
                'compte' => new Compte(
                    id: 0,
                    email: $row['email'],
                    passwordHash: "",
                    createdAt: new \DateTime(),
                    isActive: (bool)$row['is_active'],
                    language: 'fr',
                    userId: (int)$row['id'],
                    activationToken: null
                )
            ];
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toggleActive(int $userId): bool
    {
        // SQL
        $sql = "UPDATE comptes 
                SET is_active = NOT is_active
                WHERE user_id = :id";

        // Preparation
        $stmt = $this->db->prepare($sql);

        // Execution
        return $stmt->execute(['id' => $userId]);
    }

    /**
     * @inheritDoc
     */
    public function deleteUser(int $userId): bool
    {
        try {
            $this->db->beginTransaction();

            // Delete the account
            $sqlCompte = "DELETE FROM comptes WHERE user_id = :id";
            $stmtCompte = $this->db->prepare($sqlCompte);
            $stmtCompte->execute(['id' => $userId]);

            // Delete the user
            $sqlUser = "DELETE FROM users WHERE id = :id";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute(['id' => $userId]);

            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function findByToken(string $token): ?Compte
    {
        $compte = null;
        
        // SQL
        $sql = "SELECT * FROM comptes WHERE activation_token = :token LIMIT 1";
        
        // Preparation
        $stmt = $this->db->prepare($sql);
        
        // Execution
        $stmt->execute(['token' => $token]);
        $row = $stmt->fetch();

        if ($row) {
            $compte = new Compte(
                id: $row['id'],
                email: $row['email'],
                passwordHash: $row['password_hash'] ?? null,
                createdAt: new \DateTime(),
                isActive: (bool)$row['is_active'],
                language: $row['language_code'],
                userId: 0,
                activationToken: $row['activation_token'],
            );
        }

        return $compte;
    }

    /**
     * @inheritDoc
     */
    public function activateAccount(string $token, string $hashedPassword): bool
    {
        // SQL
        $sql = "UPDATE comptes 
                SET is_active = 1, activation_token = NULL, password_hash = :password
                WHERE activation_token = :token";

        // Preparation
        $stmt = $this->db->prepare($sql);

        // Execution
        return $stmt->execute([
            'password' => $hashedPassword,
            'token' => $token
        ]);
    }
  
    /**
     * @inheritDoc
     */
    public function updateRole(int $userId, string $role): bool
    {
        // SQL
        $sql = "UPDATE users SET role = :role WHERE id = :id";

        // Preparation
        $stmt = $this->db->prepare($sql);

        // Execution
        return $stmt->execute([
            'role' => $role,
            'id'   => $userId
        ]);
    }
    #endregion
}