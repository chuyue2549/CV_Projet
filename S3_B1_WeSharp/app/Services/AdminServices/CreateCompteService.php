<?php
declare(strict_types=1);

namespace App\Services\AdminServices;

use App\DAO\InterfacesDAO\IUserCompteDAO;
use App\Models\User;
use App\Models\Compte;
use App\Services\Mail\Factory\MailServiceFactory;

/**
 * Service dedicated to creating accounts
 */
class CreateCompteService
{
    #region Attributs
    private IUserCompteDAO $userCompteDao; // the user account dao
    #endregion

    #region Constructor
    /**
     * Initializes a CreateCompteService
     *
     * @param IUserCompteDAO $dao The user account dao
     */
    public function __construct(IUserCompteDAO $dao)
    {
        $this->userCompteDao = $dao;
    }
    #endregion

    #region Methods
    /**
     * Handles the creation of a new account from admin.
     *
     * @param array $input Form data ($_POST)
     * @return array [successMessage|null, errorsArray|null] An array containing the success message or the error messages
     */
    public function handle(array $input): array
    {
        $res = [null, null];
        $errors = [];

        $prenom = ucfirst(mb_strtolower(trim($input['prenom'] ?? ''), 'UTF-8'));
        $nom = ucfirst(mb_strtolower(trim($input['nom'] ?? ''), 'UTF-8'));
        $email = trim($input['email'] ?? '');
        $role = $input['role'] ?? null;

        // Validation
        if ($nom === '') $errors[] = "Le nom est requis.";
        if ($prenom === '') $errors[] = "Le prénom est requis.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide.";
        }
        if ($role === null || $role === '') {
            $errors[] = "Le rôle est requis.";
        }

        if (empty($errors)) {
            // Creates the User
            $user = new User(
                id: null,
                nom: $nom,
                prenom: $prenom,
                role: $role
            );

            // Token generation
            $token = bin2hex(random_bytes(32));

            // Creates the account
            $compte = new Compte(
                id: null,
                email: $email,
                passwordHash: null,
                createdAt: new \DateTime(),
                isActive: false,
                language: 'fr',
                userId: 0,
                activationToken: $token
            );

            // Adds it to the database
            $userId = $this->userCompteDao->create($user, $compte);

            if ($userId != 0) {
                // Activation URL construction
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
                $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
                $script = dirname($_SERVER['SCRIPT_NAME'] ?? '') ?: '';

                $baseUrl = rtrim("$protocol://$host$script", '/');
                $activationLink = $baseUrl . '/activate.php?token=' . urlencode($token);

                // Sending the activation mail
                $mailService = MailServiceFactory::create();
                $ok = $mailService->sendActivationEmail($email, $prenom, $activationLink);

                if ($ok) {
                    $res = ["Compte créé avec succès !", null];
                } else {
                    $res = [null, ["Une erreur est survenue lors de l'envoi du mail."]];
                } 
            } else {
                $res = [null, ["Erreur lors de la création du compte."]];
            }


        } else {
            $res = [null, $errors];
        }

        return $res;
    }
    #endregion
}