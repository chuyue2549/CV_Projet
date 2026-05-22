<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\InterfacesModel\IContenu;

/**
 * Represents a QCM entity
 */
class Qcm
{
    #region Attributs
    private ?int $id; // the ID of the qcm
    private ?string $matiere; // the subject of the qcm
    private IContenu $contenu; // the shared content (title, level, subject…)
    private array $questions; // the questions
    #endregion

    #region Constructor
    /**
     * Initializes a Qcm object
     *
     * @param integer|null $id The id of the qcm
     * @param string|null $matiere The subject of the qcm
     * @param IContenu $contenu The linked content item
     */
    public function __construct (?int $id, IContenu $contenu, ?string $matiere)
    {
        $this->id = $id;
        $this->matiere = $matiere;
        $this->contenu = $contenu;
    }
    #endregion

    #region Properties

    /**
     * Gets the id of the qcm
     * 
     * @return int|null The id of the qcm
     */
    public function getId(): ?int 
    { 
        return $this->id; 
    }

    /**
     * Gets the title of the qcm (from its content)
     *
     * @return string The title of the qcm
     */
    public function getTitre(): string
    {
        return $this->contenu->getTitre();
    }

    /**
     * Gets the subject of the qcm
     *
     * @return string|null The subject of the qcm
     */
    public function getMatiere(): ?string 
    {
        return $this->matiere;
    }

    /**
     * Gets the level of the qcm (from its content)
     *
     * @return int The level of the qcm
     */
    public function getNiveau(): int
    {
        return $this->contenu->getNiveau();
    }

    /**
     * Gets the status of the qcm (published or not) (from its content)
     *
     * @return bool The status of the qcm (true if it is published)
     */
    public function isPublished(): bool
    {
        return $this->contenu->isPublished();
    }

    /**
     * Gets the associated content of the qcm (title, level, subject id, author id…)
     * 
     * @return IContenu The linked content
     */
    public function getContenu(): IContenu
    {
        return $this->contenu;
    }

    /**
     * Adds a question to the qcm
     *
     * @param Question $q The question to add
     */
    public function addQuestion(Question $q) 
    {
        $this->questions[] = $q;
    }

    /**
     * Gets the questions of the qcm
     *
     * @return array The questions of the qcm
     */
    public function getQuestions(): array 
    {
        return $this->questions;
    }

    #endregion
}
