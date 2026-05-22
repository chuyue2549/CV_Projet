<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Represents an author (a user who can create content)
 */
class Auteur
{
    #region Attributs
    private int $id; // the id of the author
    private string $nom; // the last name of the author
    private string $prenom; // the first name of the author
    #endregion
    
    #region Constructor
    /**
     * Initializes an author
     *
     * @param integer $id The id of the author
     * @param string $nom The last name of the author
     * @param string $prenom The first name of the author
     */
    public function __construct(int $id, string $nom, string $prenom)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
    #endregion

    #region Methods
    /**
     * Gets the id of the author
     *
     * @return integer The id of the author
     */
    public function getId(): int 
    { 
        return $this->id; 
    }

    /**
     * Gets the last name of the author
     *
     * @return string The last name of the author
     */
    public function getNom(): string 
    { 
        return $this->nom; 
    
    }

    /**
     * Gets the first name of the author
     *
     * @return string The first name of the author
     */
    public function getPrenom(): string 
    { 
        return $this->prenom; 
    }
    #endregion
}
