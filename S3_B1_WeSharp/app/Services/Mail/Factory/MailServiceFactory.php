<?php
declare(strict_types=1);

namespace App\Services\Mail\Factory;

use App\Services\Mail\Interfaces\IMailService;
use App\Services\Mail\GoogleMailService;
use App\Services\Mail\SMTPMailService;

/**
 * Represents a factory for the mail services
 */
class MailServiceFactory
{
    /**
     * Creates the right mail service
     *
     * @return IMailService|null The right mail service
     */
    public static function create(): ?IMailService
    {
        $config = parse_ini_file(__DIR__ . '/../../../config/config.ini', true);

        // If the file can't be found
        if (!$config) {
            throw new \Exception("config.ini file not found.");
        }

        $service = null;

        // If it's google
        if ($config['MAIL']['provider'] === 'google') {
            $service = new GoogleMailService($config['GOOGLE_SMTP']);
        }
        // If it's the SMTP
        else if ($config['MAIL']['provider'] === 'smtp') {
            $service = new SMTPMailService($config['SMTP']);
        }
        // If none (if field empty...)
        else {
            throw new \Exception("Fournisseur SMTP inconnu.");
        }

        return $service;
    }
}
