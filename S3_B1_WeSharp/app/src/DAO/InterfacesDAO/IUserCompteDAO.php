<?php
declare(strict_types=1);

namespace App\DAO\InterfacesDAO;

use App\Models\Compte;
use App\Models\User;

/**
 * Declares the functions to interact with the database to handle the accounts
 */
interface IUserCompteDAO
{
    /**
     * Creates an account and its user
     * 
     * @param User $user The user to create
     * @param Compte $compte The account to create
     * @return int The id of the user inserted
     */
    public function create(User $user, Compte $compte): int;

    /**
     * Gets the user by its email
     * 
     * @param string $email The email of the user
     * @return Compte|null The account found
     */
    public function getByEmail(string $email): ?Compte;

    /**
     * Gets the account and its user
     * 
     * @param int $userId The id of the user
     * @return array|null The account and its user
     */
    public function getById(int $userId): ?array;

    /**
     * Gets all the users (account + user)
     * 
     * @return array The account and its user
     */
    public function getAll(): array;

    /**
     * Activate or desactivate a user
     * 
     * @param int The id of the user
     * @return bool True if it was successful
     */
    public function toggleActive(int $userId): bool;

    /**
     * Deletes a user
     * 
     * @param int The id of the used to delete
     * @return bool True if it was successful
     */
    public function deleteUser(int $userId): bool;

    /**
     * Finds an account by its activation token
     *
     * @param string $token The activation token
     * @return Compte|null The accound found
     */
    public function findByToken(string $token): ?Compte;
    
    /**
     * Activates an account
     *
     * @param string $token The token of the account to activate
     * @param string $hashedPassword The password to set to the account
     * @return boolean
     */
    public function activateAccount(string $token, string $hashedPassword): bool;

    /**
     * Updates the role of the user
     *
     * @param integer $userId The id of the user
     * @param string $role The role to set
     * @return boolean
     */
    public function updateRole(int $userId, string $role): bool;
}