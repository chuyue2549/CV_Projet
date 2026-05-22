<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Qcm;
use App\Models\Contenu;
use App\Models\Question;

/**
 * Tests the Qcm model.
 */
class QcmTest extends TestCase
{
    private Contenu $contenu;

    protected function setUp(): void
    {
        $this->contenu = new Contenu(
            id: 1, 
            titre: 'QCM php labubu matcha', 
            niveau: 67, 
            matiereId: 5, 
            auteurId: 10, 
            isPublished: true
        );  
    }

    /**
     * Ensures that Qcm properties are correctly set.
     */
    public function testQcmInitialization()
    {
        $qcm = new Qcm(1, $this->contenu, 'Très probablement une super matière..');

        $this->assertSame('QCM php labubu matcha', $qcm->getTitre());
        $this->assertSame('Très probablement une super matière..', $qcm->getMatiere());
        $this->assertTrue($qcm->isPublished());
    }

    /**
     * Ensures that a question can be added to a Qcm.
     */
    public function testAddQuestionAndCount() 
    {
        $contenu = new Contenu(
            id: 1, 
            titre: 'QCM php labubu matcha', 
            niveau: 67, 
            matiereId: 5, 
            auteurId: 10, 
            isPublished: true
        );        
        
        $qcm = new Qcm(1, $contenu, 'Très probablement une super matière..');


        $question1 = new Question(id: 1, qcmId: 2, enonce: 'Première question?');
        $question2 = new Question(id: 2, qcmId: 2, enonce: 'Deuxième question?');

        $qcm->addQuestion($question1);
        $qcm->addQuestion($question2);

        $this->assertCount(2, $qcm->getQuestions(), "Le QCM doit contenir 2 questions.");
        $this->assertEquals('Deuxième question?', $qcm->getQuestions()[1]->getEnonce());
        $this->assertCount(2, $qcm->getQuestions(), "Le QCM doit contenir exactement deux questions.");
    }
}
