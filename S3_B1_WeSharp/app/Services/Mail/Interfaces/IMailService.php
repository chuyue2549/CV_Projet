<?php
namespace App\Services\Mail\Interfaces;

/**
 * Declares the functions needed to use the mail service
 */
interface IMailService
{
    /**
     * Sends an email to the user to activate it's account
     *
     * @param string $toEmail Target email
     * @param string $prenom First name of the user
     * @param string $activationLink The activation link with the token
     * @return boolean True if the mail was sent 
     */
    public function sendActivationEmail(string $email, string $prenom, string $activationLink): bool;
}