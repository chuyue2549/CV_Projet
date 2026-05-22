<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Represents a subject
 */
class Matiere 
{
    #region Attributs
    private ?int $id; // the id of the subject
    private string $titre; // the title of the subject
    private ?string $description; // the description of the subject
    #endregion

    #region Constructor
    /**
     * Initializes a subject
     *
     * @param integer|null $id The id of the subject
     * @param string $titre The title of the subject
     * @param string|null $description The description of the subject
     */
    public function __construct (?int $id, string $titre, ?string $description) 
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
    }
    #endregion

    #region Properties
    /**
     * Gets the id of the subject
     *
     * @return integer|null The id of the subject
     */
    public function getId(): ?int 
    {
        return $this->id;
    }

    /**
     * Gets the title of the subject
     *
     * @return string The title of the subject
     */
    public function getTitre(): string 
    {
        return $this->titre;
    }

    /**
     * Gets the description of the subject
     *
     * @return string|null The description of the subject
     */
    public function getDescription(): ?string 
    {
        return $this->description;
    }
    #endregion
}