<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Reponse;

/**
 * Tests the Reponse model.
 */
class ReponseTest extends TestCase
{
    /**
     * Ensures that a correct answer is really correct.
     */
    public function testReponseCorrect()
    {
        $reponseCorrecte = new Reponse(id: 5, questionId: 10, reponse: 'Vrai', isCorrect: true, explications: null);
        $reponseFausse = new Reponse(id: 6, questionId: 10, reponse: 'Faux', isCorrect: false, explications: null);

        // Assertions
        $this->assertTrue($reponseCorrecte->isCorrect(), "La réponse doit retourner true pour isCorrect.");
        $this->assertFalse($reponseFausse->isCorrect(), "La réponse doit retourner false pour isCorrect.");
    }
}