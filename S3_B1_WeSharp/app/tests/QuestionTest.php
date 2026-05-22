<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Question;
use App\Models\Reponse;

/**
 * Tests the Question model.
 */
class QuestionTest extends TestCase
{
    /**
     * Ensures that an answer can be added to a question.
     */
    public function testQuestionCanAddReponses()
    {
        $question = new Question(id: 3, qcmId: 7, enonce: 'Quelle est la bonne réponse ?');
        
        $reponse1 = new Reponse(id: 1, questionId: 3, reponse: 'Réponse correcte', isCorrect: true, explications: null);
        $reponse2 = new Reponse(id: 2, questionId: 3, reponse: 'Réponse fausse', isCorrect: false, explications: null);

        $question->addReponse($reponse1);
        $question->addReponse($reponse2);

        $this->assertCount(2, $question->getReponses(), "La question doit contenir 2 réponses.");
        $this->assertTrue($question->getReponses()[0]->isCorrect(), "La première réponse doit être correcte.");
    }
}