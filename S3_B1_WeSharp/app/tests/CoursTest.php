<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Cours;
use App\Models\Contenu;

/**
 * Tests the Cours model.
 */
class CoursTest extends TestCase
{
    /**
     * Ensures that all attributes are correctly initialized.
     */
    public function testCoursCreationAndGetters()
    {
        $contenu = new Contenu(
            id: 1, 
            titre: 'Titre Test Cours', 
            niveau: 1, 
            matiereId: 5, 
            auteurId: 10, 
            isPublished: true
        );
        
        $cours = new Cours(
            id: 1,
            description: 'Description du cours',
            matiere: null,
            auteur: null,
            fichier: 'fichier_test.pdf',
            contenu: $contenu
        );

        $this->assertEquals(1, $cours->getId());
        $this->assertEquals('Titre Test Cours', $cours->getTitre());
        $this->assertTrue($cours->isPublished());
        $this->assertEquals('Description du cours', $cours->getDescription());
        $this->assertEquals('fichier_test.pdf', $cours->getFichier());
    }
}