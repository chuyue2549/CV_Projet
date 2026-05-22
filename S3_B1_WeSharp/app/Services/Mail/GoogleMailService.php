<?php
declare(strict_types=1);

namespace App\Services\Mail;

use App\Services\Mail\Interfaces\IMailService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Service that sends mails using Google SMTP
 */
class GoogleMailService implements IMailService
{
    #region Attributs
    private PHPMailer $mailer; // the PHP mailer
    #endregion

    #region Constructor
    /**
     * Initializes a GoogleMailService
     */
    public function __construct(array $config)
    {
        try {
            $this->mailer = new PHPMailer(true);

            // Config SMTP Gmail
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $config['user'];
            $this->mailer->Password = $config['password'];
            $this->mailer->Port = 587;
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
 
            // Sets the information of the mailer with the config file
            $this->mailer->setFrom($config['user'], $config['from_name']);
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = 'UTF-8';
        }
        catch (Exception $e) {
            $_SESSION['error'][] = "Une erreur est survenue lors de l'envoi du mail.";
            exit;
        }
    }
    #endregion

    #region Methods
    /**
     * @inheritDoc
     */
    public function sendActivationEmail(string $toEmail, string $prenom, string $activationLink): bool
    {
        try {
            // Sets the target
            $this->mailer->clearAllRecipients();
            $this->mailer->addAddress($toEmail);

            // Subject of the mail
            $this->mailer->Subject = 'Activation de votre compte DE-BUT';

            // Body of the mail
            $this->mailer->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px;">

                <div style="background: #f7f7f7; border: 1px solid #e0e0e0; border-radius: 12px; padding: 25px;">
                
                    <!-- Logo -->
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="https://lh3.googleusercontent.com/a-/ALV-UjWpZ0DfSJYftYf4MYuVq-OQk4hQxWQ-Q5uocwvmYWy-0fEhnLw=s200-p"
                            alt="Logo DE-BUT"
                            style="width: 90px; opacity: 0.9;">
                    </div>

                    <!-- Content -->
                    <h2 style="text-align: center; margin-top: 0;">Activation de votre compte</h2>

                    <p style="font-size: 16px; color: #333;">
                        Bonjour <strong>' . htmlspecialchars($prenom) . '</strong>,
                    </p>

                    <p style="font-size: 16px; color: #333;">
                        Votre compte vient d\'être créé sur l\'application <strong>DE-BUT</strong>.
                    </p>

                    <p style="font-size: 16px; color: #333;">
                        Pour activer votre compte et choisir votre mot de passe, cliquez sur le bouton ci-dessous :
                    </p>

                    <!-- Activation button -->
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . htmlspecialchars($activationLink) . '" 
                        style="background-color: #1e3cfa; color: white; padding: 12px 22px; text-decoration: none; font-size: 16px; border-radius: 8px; display: inline-block;">
                            Activer mon compte
                        </a>
                    </div>

                    <p style="font-size: 14px; color: #555;">
                        Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer ce message.
                    </p>

                    <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

                    <p style="font-size: 12px; color: #777; text-align: center;">
                        DE-BUT © IUT Dijon - Application d\'entraînement pour le BUT Informatique
                    </p>

                </div>

            </div>
            ';

            // Alt text
            $this->mailer->AltBody =
                "Bonjour $prenom,\n\n".
                "Votre compte DE-BUT a été créé.\n".
                "Lien d'activation : $activationLink\n\n".
                "Si vous n'êtes pas à l'origine de cette demande, ignorez ce message.";

            return $this->mailer->send();
        } catch (Exception $e) {
            return false;
        }
    }
    #endregion
}