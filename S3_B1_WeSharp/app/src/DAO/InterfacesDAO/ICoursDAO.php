<?php
declare(strict_types=1);

namespace App\DAO\InterfacesDAO;

use App\Models\Cours;

/**
 * Declares the functions to interact with the database to handle the courses
 */
interface ICoursDAO
{
    /**
     * Adds a new course in the database
     *
     * @param Cours $cours The course to add
     * @return boolean True if the request was successful
     */
    public function create(Cours $cours) : bool;

    /**
     * Deletes a course by its ID.
     *
     * @param int $id The ID of the course to delete.
     * @return bool True if the course was deleted, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Gets all the courses
     *
     * @return array An array containing the courses
     */
    public function getAll(): array;

    /**
     * Gets all the published courses
     *
     * @return array An array containing the published courses
     */
    public function getAllPublished(): array;

    /**
     * Gets all the published courses with some requirements 
     * 
     * @return array An array array containing the published courses that meet the requirements
     */
    public function getAllFiltered(?string $q = null, ?int $matiereId = null, ?int $niveau = null): array;
    
    /**
     * Gets a course by its id
     *
     * @param integer $id The id of the course to get
     * @return Cours|null The retrived obtained or null if none was found
     */
    public function getById(int $id) : ?Cours;

    /**
     * Publishes or unpublishes the course
     *
     * @param integer $id The course to change its publication status
     * @return boolean True if the request was successful
     */
    public function togglePublication(int $id): bool;

    /**
     * Gets all authors
     * 
     * @return array An array containing every subjects
     */
    public function getAuteurs(): array;

    /**
     * Gets all levels from table contenu
     * 
     * @return array An array containing every class's level
     */
    public function getNiveaux(): array;

    /**
     * Updates the course
     *
     * @param Cours $c The course uptated
     * @return boolean True if it was successful
     */
    public function update(Cours $c): bool;
}
