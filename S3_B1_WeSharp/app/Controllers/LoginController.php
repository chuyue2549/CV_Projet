<?php
declare(strict_types=1);

namespace App\Controllers;

use App\DAO\CompteDAO;
use App\DAO\UserDAO;
use App\DAO\InterfacesDAO\IUserCompteDAO;
use App\Database\DatabaseConnection;

/**
 * Responsible for the authentication system
 */
class LoginController 
{
    #region Attributs
    private IUserCompteDAO $userCompteDAO; // DAO handling the accounts / users
    #endregion

    #region Contructor
    /**
     * Initializes a LoginController
     *
     * @param IUserCompteDAO $userCompteDAO Instance of the account / users dao
     */
    public function __construct(IUserCompteDAO $userCompteDAO) 
    {
        $this->userCompteDAO = $userCompteDAO;
    }
    #endregion

    #region Methods
    /**
     * Tries to log the users with the email and password sent
     *
     * @return void
     */
    public function login() : void
    {
        if (!isset($_SESSION['compte'])) 
        {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = trim($_POST['email'] ?? '');
                $password = trim($_POST['password'] ?? '');

                $compte = $this->userCompteDAO->getByEmail($email);


                if ($compte && $compte->verifyPassword($password)) 
                {
                    // Checks if the account is active
                    if (!$compte->isActive()) 
                    {
                        $_SESSION['error'] = "Le compte est désactivé.";
                        header("Location: login.php");
                        exit;
                    } else {
                        $userData = $this->userCompteDAO->getById($compte->getUserId());
                        $user = $userData['user'];
                        
                        $_SESSION['compte'] = [
                            'compte_id' => $compte->getId(),
                            'email' => $compte->getEmail(),
                            'created_at' => $compte->getCreatedAt(),
                            'is_active' => $compte->isActive(),
                            'language' => $compte->getLanguage(),
                            'user_id' => $user->getId(),
                            'nom' => $user->getNom(),
                            'prenom' => $user->getPrenom(),
                            'role' => $user->getRole()
                        ];
                        
                        header("Location: index.php?page=accueil");
                        exit;
                    }
                } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect.";
                    header("Location: login.php");
                    exit;
                }
            }
        }
        else {
            header("Location: index.php");
            die;
        }
    }

    /**
     * Logs out the current user
     *
     * @return void
     */
    public function logout() : void 
    {
        session_destroy();
        header('Location: login.php');
        exit;
    }
    #endregion
}