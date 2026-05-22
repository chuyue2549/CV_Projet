<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Compte;
use DateTime;

/**
 * Tests the Compte model.
 */
class CompteTest extends TestCase
{
    private string $plainPassword = 'testPassword123';
    private string $hashedPassword;

    /**
     * Creates the hashed password from the plain password to test the login
     */
    protected function setUp(): void
    {
        $this->hashedPassword = password_hash($this->plainPassword, PASSWORD_DEFAULT);
    }

    /**
     * Tests the verification of the password (success)
     */
    public function testVerifyPasswordSucceeds()
    {
        $compte = new Compte(
            id: 1, 
            email: 'test@example.com', 
            passwordHash: $this->hashedPassword, 
            createdAt: new DateTime(), 
            isActive: true, 
            language: 'fr', 
            userId: 1,
            activationToken: null
        );

        $result = $compte->verifyPassword($this->plainPassword);
        
        $this->assertTrue($result, "La vérification du mot de passe doit réussir avec le mot de passe correct.");
    }

    /**
     * Tests if the password verificator detects a wrong password
     */
    public function testVerifyPasswordFails()
    {
        $compte = new Compte(
            id: 1, 
            email: 'test@example.com', 
            passwordHash: $this->hashedPassword, 
            createdAt: new DateTime(), 
            isActive: true, 
            language: 'fr', 
            userId: 1,
            activationToken: null
        );
        
        $incorrectPassword = 'wrongPassword';
        $result = $compte->verifyPassword($incorrectPassword);
        
        $this->assertFalse($result, "La vérification du mot de passe doit échouer avec un mot de passe incorrect.");
    }
}