<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\InterfacesModel\IContenu;

/**
 * Represents a course
 */
class Cours
{
    #region Attributs
    private ?int $id; // the id of the course
    private ?string $description; // the description of the course
    private ?string $matiere; // the subject name
    private ?string $auteur; // the author name
    private string $fichier; // the path to the file of the course
    private IContenu $contenu; // the linked content (title, level, subject, author…)
    #endregion


    #region Constructor
    /**
     * Initializes a course
     *
     * @param integer|null $id The id of the course
     * @param string|null $description The description of the course
     * @param string|null $matiere The subject of the course
     * @param string|null $auteur The author of the course
     * @param string $fichier The name of the file
     * @param IContenu $contenu The content information shared by all content types
     */
    public function __construct (?int $id, string $fichier, IContenu $contenu, ?string $description = null, ?string $matiere = null, ?string $auteur = null)
    {
        $this->id = $id;
        $this->description = $description;
        $this->matiere = $matiere;
        $this->auteur = $auteur;
        $this->fichier = $fichier;
        $this->contenu = $contenu;
    }
    #endregion


    #region Properties
    /**
     * Gets the id of the course
     * 
     * @return int The id of the course
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the title of the course (from its content)
     *
     * @return string The title of the course
     */
    public function getTitre(): string
    {
        return $this->contenu->getTitre();
    }

    /**
     * Gets the description of the course
     * 
     * @return string|null The course's description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Gets the subject of the course
     *
     * @return string|null The subject of the course
     */
    public function getMatiere(): ?string 
    {
        return $this->matiere;
    }

    /**
     * Gets the author of the course
     * 
     * @return string|null The author of the course
     */
    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    /**
     * Gets the level of the course (from its content)
     *
     * @return int The level of the course
     */
    public function getNiveau(): int
    {
        return $this->contenu->getNiveau();
    }

    /**
     * Gets the file path of the course
     * 
     * @return string The course's file path
     */
    public function getFichier(): string
    {
        return $this->fichier;
    }

    /**
     * Gets the status of the course (published or not) (from its content)
     *
     * @return bool The status of the course (true if it is published)
     */
    public function isPublished(): bool
    {
        return $this->contenu->isPublished();
    }

    /**
     * Gets the shared content entity (title, level, subject…)
     * 
     * @return IContenu The content linked to this course
     */
    public function getContenu(): IContenu
    {
        return $this->contenu;
    }
    #endregion
}
