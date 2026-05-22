<?php
declare(strict_types=1);

namespace App\DAO\InterfacesDAO;

use App\Models\Qcm;

/**
 * Declares the functions to interact with the database to handle the qcms
 */
interface IQcmDAO 
{
    /** 
     * Gets all published QCMs 
     */
    public function getAll(): array;

     /**
     * Gets all the published qcms with some requirements 
     * 
     * @return array An array array containing the published qcms that meet the requirements
     */
    public function getAllFiltered( ?string $q = null, ?int $matiereId = null, ?int $niveau = null): array;
    
    /** 
     * Gets a QCM by its id
     * 
     * @param int $id The id of the qcm wanted
     * @return ?array The qcm
     */
    public function getById(int $id): ?Qcm;

    /** 
     * Gets all questions for a QCM 
     * 
     * @param int $qcmId The id of the qcm
     * @return array The questions of the qcm
     */
    public function getQuestions(int $qcmId): array;

    /** 
     * Gets all answers for a question 
     * 
     * @param int $questionId The id of the question
     * @return array The answers of the question
     */
    public function getReponses(int $questionId): array;

    /** 
     * Creates a full QCM with its questions and answers 
     * 
     * @param array $data The qcm data
     * @return bool True if the request was successful
     */
    public function createQcm(array $qcmData): bool;

    /**
     * Deletes a qcm with its questions and answers
     *
     * @param integer $id The quiz of the id to delete
     * @return boolean True if the request was successful
     */
    public function deleteQcm(int $id): bool;

    /**
     * Get all levels form table contenu
     * 
     * @return array An array containing every qcm's level
     */
    public function getNiveaux(): array;

    /** 
     * Publishes or unpublishes the qcm
     *
     * @param integer $id The qcm to change its publication status
     * @return boolean True if the request was successful
     */
    public function togglePublication(int $id): bool;

    /**
     * Updates the qcm
     *
     * @param Qcm $q The qcm object updated
     * @return boolean True if it was successful
     */
    public function update(Qcm $q): bool;

    /**
     * Updates a question of a qcm
     *
     * @param integer $id The id of the question
     * @param string $enonce The new question
     * @return boolean True if it was successful
     */
    public function updateQuestion(int $id, string $enonce): bool;

    /**
     * Updates an answer of a qcm
     *
     * @param integer $id The id of the answer
     * @param string $texte The new text (or the same) of the answer
     * @param boolean $correct True if the answer should be correct, false if not
     * @return boolean True if it was successful
     */
    public function updateReponse(int $id, string $texte, bool $correct): bool; 
}
?>