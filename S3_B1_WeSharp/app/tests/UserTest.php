<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Models\User;

/**
 * Tests the User model.
 */
class UserTest extends TestCase
{
    /**
     * Tests the name
     */
    public function testGetFullNameFormatsCorrectly()
    {
        $user = new User(id: 1, nom: 'DUPONT', prenom: 'Jean', role: 'etudiant');
        $this->assertEquals('Jean DUPONT', $user->getFullName(), "Le nom complet doit être 'Prénom NOM' en majuscules.");
    }

    /**
     * Tests the role admin
     */
    public function testUserIsAdmin()
    {
        $admin = new User(id: 2, nom: 'SMITH', prenom: 'Alice', role: 'admin');
        $student = new User(id: 3, nom: 'DOE', prenom: 'John', role: 'etudiant');
        
        $this->assertEquals('admin', $admin->getRole(), "Le rôle 'admin' doit être reconnu comme admin.");
        $this->assertEquals('etudiant', $student->getRole(), "Le rôle 'etudiant' doit être reconnu comme etudiant.");
    }

    /**
     * Tests the role director
     */
    public function testUserIsDirecteur()
    {
        $directeur = new User(id: 4, nom: 'MARTIN', prenom: 'Paul', role: 'directeur');
        $student = new User(id: 5, nom: 'GARCIA', prenom: 'Marie', role: 'etudiant');

        $this->assertEquals('directeur', $directeur->getRole(), "Le rôle 'directeur' doit être reconnu.");
        $this->assertEquals('etudiant', $student->getRole(), "Le rôle 'etudiant' ne doit pas être reconnu comme directeur.");
    }
}