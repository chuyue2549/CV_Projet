<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Compte;

/**
 * Represents a User
 */
class User 
{
    #region Attributs
    private ?int $id; // the id of the user
    private string $nom; // the first name of the user
    private string $prenom; // the first name of the user
    private string $role; // the role of the user
    #endregion

    #region Constructor
    /**
     * Initializes a user
     *
     * @param int|null $id The user's ID
     * @param string $nom The user's last name
     * @param string $prenom The user's first name
     * @param string $role The user's role
     */
    public function __construct(?int $id, string $nom, string $prenom, string $role)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->role = $role;
    }
    #endregion

    #region Properties
    /**
     * Gets the user's ID
     * 
     * @return int|null The id of the user
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the user's last name
     * 
     * @return string The last name of the user
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Gets the user's first name
     * 
     * @return string The first name of the user
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Gets the user's full name
     * 
     * @return string The full name of the user
     */
    public function getFullName(): string
    {
        return $this->prenom . ' ' . strtoupper($this->nom);
    }

    /**
     * Gets the user's role
     * 
     * @return string The role of the user
     */
    public function getRole(): string
    {
        return $this->role;
    }
    #endregion
}