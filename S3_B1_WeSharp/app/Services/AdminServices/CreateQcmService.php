<?php
declare(strict_types=1);

namespace App\Services\AdminServices;

use App\DAO\InterfacesDAO\IQcmDAO;
use App\Models\Contenu;
use App\Models\Question;
use App\Models\Reponse;

/**
 * Service dedicated to creating qcms
 */
class CreateQcmService
{
    #region Attributs
    private IQcmDAO $qcmDao; // the qcm dao
    #endregion

    #region Constructor
    /**
     * Initializes a CreateQcmService
     *
     * @param IQcmDAO $dao The qcm dao
     */
    public function __construct(IQcmDAO $dao)
    {
        $this->qcmDao = $dao;
    }
    #endregion

    #region Method
    /**
     * Handles the creation of a new qcm from admin.
     *
     * @param array $input Form data ($_POST)
     * @return array [successMessage|null, errorsArray|null] An array containing the success message or the error messages
     */
    public function handle(array $input): array
    {
        $res = [null, null];
        $errors = [];

        $titre = trim($input['titre'] ?? '');
        $niveau = (int)($input['niveau'] ?? 0);
        $matiereId = (int)($input['matiere_id'] ?? 0);


        if ($titre === '') $errors[] = "Le titre est requis.";
        if ($niveau <= 0) $errors[] = "Le niveau est requis.";
        if ($matiereId <= 0) $errors[] = "La matière est requise.";

        if (empty($errors)) {
            // Builds the Contenu of the Qcm
            $contenuQcm = new Contenu(
                id: null,
                titre: $titre,
                niveau: $niveau,
                matiereId: $matiereId,
                auteurId: 1,
                isPublished: false
            );

            $questions = [];

            // Builds questions and answers
            foreach ($input['questions'] ?? [] as $q) {

                $enonce = trim($q['enonce'] ?? '');

                if ($enonce === '') {
                    $res = [null, ["Une question ne peut pas être vide."]];
                    return $res;
                }

                $question = new Question($enonce, null, null);

                // Reset responses for each question
                $reponses = [];

                foreach ($q['reponses'] as $r) {

                    $texte = trim($r['texte'] ?? '');

                    // Creates an answer
                    if ($texte != '') {
                        $reponses[] = new Reponse(
                            id: null,
                            reponse: $texte,
                            isCorrect: isset($r['is_correct']),
                            questionId: null,
                            explications: null
                        );
                    };   
                }

                // Validate responses
                $nonEmpty = array_filter($reponses, fn($r) => trim($r->getReponse()) !== "");
                $hasCorrect = array_reduce($reponses, fn($carry, $r) => $carry || $r->isCorrect(), false);

                if (count($nonEmpty) < 2 || !$hasCorrect) {
                    $res = [null, ["Chaque question doit avoir au moins deux réponses non vides et une réponse correcte."]];
                    return $res;
                }

                // Attach responses to question
                foreach ($reponses as $r) {
                    $question->addReponse($r);
                }

                $questions[] = $question;
            }

            // Prepare the informations to create the qcm
            $data = [
                'contenu' => $contenuQcm,
                'questions' => $questions
            ];

            // Detects success / error
            if ($this->qcmDao->createQcm($data)) {
                $res = ["QCM créé avec succès !", null];
            } else {
                $res = [null, ["Erreur lors de la création du QCM"]];
            }
        } else {
            $res = [null, $errors];
        }

        return $res;
    }
    #endregion
}