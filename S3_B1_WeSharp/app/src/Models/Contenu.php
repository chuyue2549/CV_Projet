<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\InterfacesModel\IContenu;

/**
 * Represents the shared content information for courses, QCMs and exercises
 */
class Contenu implements IContenu
{
    #region Attributs
    private ?int $id; // the id of the content
    private string $titre; // the title of the content
    private int $niveau; // the level of the content
    private int $matiereId; // the subject id of the content
    private int $auteurId; // the author id of the content
    private bool $isPublished; // the publication status
    #endregion


    #region Constructor
    /**
     * Initializes a content item
     *
     * @param integer|null $id The id of the content
     * @param string $titre The title of the content
     * @param integer $niveau The level of the content
     * @param integer $matiereId The subject id of the content
     * @param integer $auteurId The author id of the content
     * @param boolean|null $isPublished The publication status
     */
    public function __construct(?int $id, string $titre, int $niveau, int $matiereId, int $auteurId, ?bool $isPublished = false) 
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->niveau = $niveau;
        $this->matiereId = $matiereId;
        $this->auteurId = $auteurId;
        $this->isPublished = $isPublished;
    }
    #endregion


    #region Properties

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @inheritDoc
     */
    public function getNiveau(): int
    {
        return $this->niveau;
    }

    /**
     * @inheritDoc
     */
    public function getMatiereId(): int
    {
        return $this->matiereId;
    }

    /**
     * @inheritDoc
     */
    public function getAuteurId(): int
    {
        return $this->auteurId;
    }

    /**
     * @inheritDoc
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * @inheritDoc
     */
    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    /**
     * @inheritDoc
     */
    public function setNiveau(int $niveau): void {
        $this->niveau = $niveau;
    }

    /**
     * @inheritDoc
     */
    public function setMatiereId(int $matiereId): void {
        $this->matiereId = $matiereId;
    }

    /**
     * @inheritDoc
     */
    public function setAuteurId(int $auteurId): void {
        $this->auteurId = $auteurId;
    }

    /**
     * @inheritDoc
     */
    public function setIsPublished(bool $value): void {
        $this->isPublished = $value;
    }

    #endregion
}
