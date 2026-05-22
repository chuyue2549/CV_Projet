<?php
/**
 * Script autonome pour créer un utilisateur (User) et un compte (Compte) associé
 * avec un mot de passe haché correctement.
 * * Ce script est utilisé pour insérer un compte d'administration de test et vérifier
 * l'authentification.
 */

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\DatabaseConnection;
use PDO;
use DateTime;
use App\Models\User;
use App\Models\Compte;

$TEST_EMAIL = 'admin_test@wesharp.fr';
$TEST_PASSWORD = 'password123'; 
$USER_NOM = 'ADMIN';
$USER_PRENOM = 'Principal';
$USER_ROLE = 'admin'; 

try {
    $db = (new DatabaseConnection())->getDb();
    
    echo "<h1>Tool de Création de Compte Admin</h1>";
    echo "<p>Connexion BDD établie.</p>";
    
} catch (\Throwable $e) {
    die("<p style='color:red;'>ERREUR FATALE DE CONNEXION : Vérifiez votre fichier config.ini.</p> Message: " . $e->getMessage());
}

$passwordHash = password_hash($TEST_PASSWORD, PASSWORD_DEFAULT);

$db->beginTransaction();

try {
    $sqlUser = "INSERT INTO users (nom, prenom, role) VALUES (:nom, :prenom, :role)";
    $stmtUser = $db->prepare($sqlUser);
    $stmtUser->execute([
        ':nom' => $USER_NOM,
        ':prenom' => $USER_PRENOM,
        ':role' => $USER_ROLE
    ]);

    $userId = (int)$db->lastInsertId();
    
    if ($userId === 0) {
        throw new \Exception("La création de l'utilisateur a échoué (lastInsertId est 0).");
    }

    $sqlCompte = "INSERT INTO comptes (user_id, email, password_hash, created_at, is_active, language_code)
                  VALUES (:user_id, :email, :password_hash, :created_at, :is_active, :language)";
    
    $stmtCompte = $db->prepare($sqlCompte);
    $stmtCompte->execute([
        ':user_id' => $userId,
        ':email' => $TEST_EMAIL,
        ':password_hash' => trim($passwordHash),
        ':created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        ':is_active' => 1, 
        ':language' => 'fr'
    ]);

    $db->commit();
    
    echo "<br><p style='color:green; font-weight:bold;'>✅ SUCCÈS : Compte ADMIN créé.</p>";
    echo "<ul>";
    echo "<li><strong>User ID inséré:</strong> $userId</li>";
    echo "<li><strong>Email:</strong> $TEST_EMAIL</li>";
    echo "<li><strong>Mot de passe testé:</strong> $TEST_PASSWORD</li>";
    echo "</ul>";
    echo "<p>Vous pouvez maintenant tester la connexion sur <a href='public/index.php?page=login'>la page de login</a>.</p>";

} catch (\Throwable $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    echo "<br><p style='color:red; font-weight:bold;'>❌ ERREUR DE TRANSACTION BDD :</p>";
    echo "Message: " . $e->getMessage() . "<br>";
    echo "Cause probable: La table 'users' ou 'comptes' contient déjà cet email (contrainte UNIQUE) ou une clé étrangère est violée.";
}

?>