<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use DateTime;

/**
 * Represents an account
 */
class Compte 
{
    #region Attributs
    private ?int $id; // the id of the account
    private string $email; // the email linked to the account
    private ?string $passwordHash; // the HASHED password of the account
    private DateTime $createdAt; // date of creation of the account
    private bool $isActive; // the status of the account : active (true) or not (false)
    private string $language; // the chosen language of the website chosen (default : "fr" -> french)
    private int $userId; // the user linked to the account
    private ?string $activationToken; // the activation token of the account
    #endregion

    #region Constructor
    /**
     * Initializes an account
     *
     * @param int|null $id The ID of the account
     * @param string $email The login email
     * @param string|null $passwordHash The hashed password
     * @param DateTime $createdAt Date of creation
     * @param bool $isActive Whether the account is active
     * @param string $language User language setting
     * @param int $userId The linked user entity
     * @param string|null $activationToken The activation token of this account
     */
    public function __construct(?int $id, string $email, ?string $passwordHash, DateTime $createdAt, bool $isActive, string $language, int $userId, ?string $activationToken) 
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
        $this->isActive = $isActive;
        $this->language = $language;
        $this->userId = $userId;
        $this->activationToken = $activationToken;
    }
    #endregion

    #region Properties
    /**
     * Gets the id of the account
     *
     * @return integer|null The id of the account
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the email of the account
     *
     * @return string The email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Returns the hashed password
     * 
     * @return string|null The password hash
     */
    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    /**
     * Gets the date of account creation
     * 
     * @return DateTime The date of account creation
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Returns true if the account is active
     * 
     * @return bool True if the account is active
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Gets the user language
     * 
     * @return string The language of the account
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Gets the linked user id
     * 
     * @return int The user id linked to the account
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Gets the activation token of the account
     *
     * @return string|null The activation token
     */
    public function getActivationToken(): ?string 
    {
        return $this->activationToken;
    }
    #endregion

    #region Methods
    /**
     * Verify if the password given is the user's password (with the hashed password)
     * @param bool If the password is the right one
     */
    public function verifyPassword(string $password) : bool 
    {
        $res = false;
        
        if ($this->passwordHash != null) {
            $res = password_verify($password, $this->passwordHash);
        }

        return $res;
    }
    #endregion
}