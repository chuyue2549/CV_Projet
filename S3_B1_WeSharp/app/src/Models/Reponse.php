<?php
declare(strict_types=1);

namespace App\Models;

/**
 * Represents an anwser of a question
 */
class Reponse 
{
    #region Attributs
    private ?int $id; // the id of the answer
    private ?int $questionId; // the id of the question
    private string $reponse; // the answer
    private bool $isCorrect; // if the answer is correct or not
    private ?string $explications; // explainations about the answer
    #endregion

    #region Constructor
    /**
     * Initializes an answer
     *
     * @param integer|null $id The id of the answer
     * @param integer|null $questionId The id of the question
     * @param string $response The answer
     * @param boolean|null $isCorrect If the answer is correct or not (false if not specified)
     * @param string|null $explications Explainations about the answer
     */
    public function __construct (string $reponse, ?int $id = null, bool $isCorrect = false, ?int $questionId = null, ?string $explications = null) 
    {
        $this->id = $id;
        $this->questionId = $questionId;
        $this->reponse = $reponse;
        $this->isCorrect = $isCorrect;
        $this->explications = $explications;
    }
    #endregion

    #region Properties
    /**
     * Gets the id of the anwser
     *
     * @return integer The id of the answer
     */
    public function getId(): int 
    { 
        return $this->id; 
    }

    /**
     * Gets the answer
     *
     * @return string The answer
     */
    public function getReponse(): string 
    { 
        return $this->reponse; 
    }

    /**
     * Gets if the answer is correct or not
     *
     * @return boolean True if the answer is correct, false if not
     */
    public function isCorrect(): bool 
    { 
        return $this->isCorrect; 
    }

    /**
     * Gets the explaination of the answer (why it's true of why it's false)
     *
     * @return string|null
     */
    public function getExplications(): ?string 
    { 
        return $this->explications; 
    }
    #endregion
}