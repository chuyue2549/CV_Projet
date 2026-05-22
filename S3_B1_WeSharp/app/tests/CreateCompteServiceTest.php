<?php
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Services\AdminServices\CreateCompteService;
use App\DAO\InterfacesDAO\IUserCompteDAO;
use App\Models\User;
use App\Models\Compte;

/**
 * Tests the CreateCompteService service.
 */
class CreateCompteServiceTest extends TestCase
{
    private IUserCompteDAO $userCompteDAOMock;
    private CreateCompteService $service;

    /**
     * Creayes the mock DAOs and gets an instance of the service
     */
    protected function setUp(): void
    {
        $this->userCompteDAOMock = $this->createMock(IUserCompteDAO::class);

        $this->service = new CreateCompteService($this->userCompteDAOMock);
    }

    /**
     * Tests the the creation of a user
     */
    public function testCreateCompte()
    {
        $data = [
            'nom' => 'Test',
            'prenom' => 'Service',
            'email' => 'service@test.com',
            'password' => 'securepwd',
            'role' => 'etudiant',
            'is_active' => true,
        ];
        
        $this->userCompteDAOMock->expects($this->once()) 
                                 ->method('create')
                                 ->willReturn(100); 

        $result = $this->service->handle($data);
        
        // Checks the structure of the result returned
        $this->assertIsArray($result, "Le service doit retourner un tableau de résultats.");
        $this->assertStringContainsString('Compte créé avec succès', $result[0], "Le message de succès doit être retourné.");
        $this->assertNull($result[1], "Le champ erreur doit être null en cas de succès.");
    }
    
    /**
     * Tests that the creation fails if the User insertion fails
     */
    public function testCreateCompteFailsIfUserCreationFails()
    {
        $data = [
            'nom' => 'Test',
            'prenom' => 'Fail',
            'email' => 'fail@test.com',
            'password' => 'securepwd',
            'role' => 'etudiant',
            'is_active' => true,
        ];

        $this->userCompteDAOMock->expects($this->once())
                                 ->method('create')
                                 ->willReturn(0);

        $result = $this->service->handle($data);

        // Checks if there is an error message
        $this->assertIsArray($result, "Le service doit retourner un tableau [message, erreurs] en cas d'échec.");
        $this->assertNull($result[0], "Le champ message de succès doit être null en cas d'échec.");
        $this->assertIsArray($result[1], "Le champ erreur doit être un tableau en cas d'échec.");
        $this->assertStringContainsString('Erreur lors de la création du compte', $result[1][0], "Le message d'erreur doit être retourné.");
    }
}