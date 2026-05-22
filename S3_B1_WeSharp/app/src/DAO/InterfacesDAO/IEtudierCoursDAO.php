<?php
declare(strict_types=1);

namespace App\DAO\InterfacesDAO;


/**
 * Interface for EtudierCoursDAO.
 * Handles the relation between users and courses (viewed / completed).
 */
interface IEtudierCoursDAO
{
    /**
     * Returns a map of completed courses for a given user.
     *
     * @param int $userId The ID of the user
     * @return array The map of course id and completion status
     */
    public function getById(int $userId): array;

    /**
     * Toggles the completion status of a course for a user.
     *
     *  - If no row exists for (user_id, cours_id),
     *    it will insert one with is_completed = 1.
     *  - If a row already exists,
     *    it will flip is_completed (0 <-> 1).
     *
     * @param int $userId  The ID of the user
     * @param int $coursId The ID of the course
     * @return bool True on success, false otherwise
     */
    public function toggleCompletion(int $userId, int $coursId): bool;
}
