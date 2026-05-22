<?php
declare(strict_types=1);

namespace App\Models\InterfacesModel;

/**
 * Represents common content properties shared by all contents (courses, QCMs, exercises).
 */
interface IContenu {
     /**
     * Gets the id of the content
     * 
     * @return int The id of the content
     */
    public function getId(): int;

    /**
     * Gets the title of the content
     * 
     * @return string The title of the content
     */
    public function getTitre(): string;

    /**
     * Gets the level of the content
     * 
     * @return int The level of the content
     */
    public function getNiveau(): int;

    /**
     * Gets the subject id of the content
     * 
     * @return int The subject id of the content
     */
    public function getMatiereId(): int;

    /**
     * Gets the author id of the content
     * 
     * @return int The author id of the content
     */
    public function getAuteurId(): int;

    /**
     * Gets the publication status
     *
     * @return boolean True if the content is published
     */
    public function isPublished(): bool;

    /**
     * Sets the title of the content
     */

    public function setTitre(string $titre): void;

    /**
     * Sets the level of the content
     */

    public function setNiveau(int $niveau): void;

    /**
     * Sets the subject id of the content
     */
    public function setMatiereId(int $matiereId): void;

    /**
     * Sets the author id of the content
     */
    public function setAuteurId(int $auteurId): void;

    /**
     * Sets the publication status
     */
    public function setIsPublished(bool $value): void;
}
    
