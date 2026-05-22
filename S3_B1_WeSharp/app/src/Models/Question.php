<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Represents a question
 */
class Question 
{
    #region Attributs
    private ?int $id; // the id of the question
    private ?int $qcmId; // the id of the QCM
    private string $enonce; // the question
    private array $reponses; // the answers
    #endregion

    #region Constructor
    /**
     * Initializes a qcm question
     *
     * @param integer|null $id The id of the question
     * @param integer|null $qcmId The id of the qcm
     * @param string $enonce The question
     */
    public function __construct (string $enonce, ?int $id = null, ?int $qcmId = null,) 
    {
        $this->id = $id;
        $this->qcmId = $qcmId;
        $this->enonce = $enonce;
        $this->reponses = [];
    }
    #endregion

    #region Properties
    /**
     * Gets the id of the question
     *
     * @return integer|null The id of the question
     */
    public function getId(): ?int 
    {
        return $this->id;
    }

    /**
     * Gets the id of the qcm
     *
     * @return integer The id of the qcm
     */
    public function getQcmId(): int 
    {
        return $this->qcmId;
    }

    /**
     * Gets the question
     *
     * @return string The question
     */
    public function getEnonce(): string 
    {
        return $this->enonce;
    }

    /**
     * Adds an answer to the question
     *
     * @param Reponse $r The answer to add
     */
    public function addReponse(Reponse $r) 
    {
        $this->reponses[] = $r;
    }

    /**
     * Gets the answers of the question
     *
     * @return array The answers
     */
    public function getReponses(): array 
    {
        return $this->reponses;
    }

     /**
     * Sets the answers of the question
     */
    public function setReponses(array $reponses): void
    {
        $this->reponses = $reponses;
    }

    #endregion
}