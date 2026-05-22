-- ============================================================
-- Base de données : DE-BUT (Dispositif d’Entraînement pour le BUT)
-- ============================================================

-- ============================================================
-- TABLES PRINCIPALES
-- ============================================================

CREATE TABLE matieres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Identité de la personne (sans login)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    role ENUM('etudiant', 'directeur', 'admin') NOT NULL DEFAULT 'etudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de connexion (compte) liées à un user
CREATE TABLE comptes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    language_code CHAR(2) NOT NULL DEFAULT 'fr',
    activation_token VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contenu factorisé (commun à cours / qcms / exercices)
CREATE TABLE contenu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    niveau INT NOT NULL,
    is_published BOOLEAN NOT NULL DEFAULT TRUE,
    matiere_id INT NOT NULL,
    auteur_id INT NOT NULL,
    FOREIGN KEY (matiere_id) REFERENCES matieres(id),
    FOREIGN KEY (auteur_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Spécialisation : cours
CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL UNIQUE,
    description TEXT,
    fichier VARCHAR(255),
    FOREIGN KEY (contenu_id) REFERENCES contenu(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Spécialisation : qcms
CREATE TABLE qcms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL UNIQUE,
    FOREIGN KEY (contenu_id) REFERENCES contenu(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Spécialisation : exercices
CREATE TABLE exercices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL UNIQUE,
    FOREIGN KEY (contenu_id) REFERENCES contenu(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- QUESTIONS ET RÉPONSES
-- ============================================================

CREATE TABLE questions_qcm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    qcm_id INT NOT NULL,
    enonce TEXT NOT NULL,
    FOREIGN KEY (qcm_id) REFERENCES qcms(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE reponses_qcm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    reponse TEXT NOT NULL,
    is_correct BOOLEAN NOT NULL DEFAULT FALSE,
    explications TEXT,
    FOREIGN KEY (question_id) REFERENCES questions_qcm(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE questions_exercice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enonce TEXT NOT NULL,
    correction TEXT NOT NULL,
    exercice_id INT NOT NULL,
    FOREIGN KEY (exercice_id) REFERENCES exercices(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLES DE LIAISON (SUIVI DES ÉTUDIANTS)
-- ============================================================

CREATE TABLE etudier_cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cours_id INT NOT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT FALSE,
    date_completion DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_cours (user_id, cours_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cours_id) REFERENCES cours(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE passer_qcm (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    qcm_id INT NOT NULL,
    score INT NOT NULL,
    date_passage DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (qcm_id) REFERENCES qcms(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE effectuer_exercice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    exercice_id INT NOT NULL,
    is_done BOOLEAN NOT NULL DEFAULT FALSE,
    date_realisation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (exercice_id) REFERENCES exercices(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




-- ============================================================
-- INSERTIONS DE BASE
-- ============================================================

-- --- MATIERES
INSERT INTO matieres (nom, description) VALUES
('Algorithmique', 'Bases de la logique algorithmique'),
('Base de données', 'Introduction au SQL et à la modélisation'),
('Développement Web', 'HTML, CSS, PHP et structure MVC');

-- --- USERS (identité des directeurs / auteurs)
INSERT INTO users (nom, prenom, role) VALUES
('Simonet', 'Matthieu', 'directeur'),
('Mendes', 'Florence', 'directeur');

-- --- COMPTES (données de connexion, fr par défaut)
INSERT INTO comptes (user_id, email, password_hash, created_at, is_active, language_code) VALUES
(1, 'matthieu.simonet@iut-corp.fr', null, NOW(), TRUE, 'fr'),
(2, 'florence.mendes@iut-corp.fr', null, NOW(), TRUE, 'fr');

-- =========================================================
-- COURS (via CONTENU + COURS)
-- =========================================================

-- On crée d’abord les enregistrements dans "contenu"
INSERT INTO contenu (titre, niveau, matiere_id, auteur_id, is_published) VALUES
('Introduction aux algorithmes', 1, 1, 1, TRUE),
('Boucles et tableaux',          2, 1, 1, TRUE),
('Modélisation relationnelle',   1, 2, 2, TRUE),
('HTML & CSS avancé',           1, 3, 2, FALSE);

-- Puis on complète avec la partie spécifique aux cours
-- (on suppose que les contenus insérés ci-dessus ont les IDs 1 à 4)
INSERT INTO cours (contenu_id, description, fichier) VALUES
(1, 'Découvrir les bases de la logique algorithmique et les structures conditionnelles.', '68ebbdfb49667-2 - Section Algorithmes de César.pdf'),
(2, 'Manipulation des boucles et structures de données simples.',                         '68ebbf915c95d-TD1_R3.03.pdf'),
(3, 'Créer un MCD et comprendre les clés primaires/étrangères.',                         '68efcdd89ad35-SAE3 tuto SuiviProjetTeams  2025 (1).pdf'),
(4, 'Mettre en page des sites web modernes.',                                            '68f0ac5b2f365-B1 - DE-BUT.pdf');

-- =========================================================
-- QCMs (via CONTENU + QCMS + questions + réponses)
-- =========================================================

-- Contenu pour les QCM (on continue la numérotation : IDs 5 et 6)
INSERT INTO contenu (titre, niveau, matiere_id, auteur_id, is_published) VALUES
('Bases de l’Algorithmique', 1, 1, 1, TRUE),
('Introduction à PHP',      1, 2, 2, TRUE);

-- QCM liés à ces contenus
-- On suppose que les contenus précédents ont reçu les IDs 5 et 6
INSERT INTO qcms (contenu_id) VALUES
(5), -- QCM 1
(6); -- QCM 2

-- =========================================================
-- QCM 1 : Algorithmique - Bases
-- =========================================================

-- Question 1
INSERT INTO questions_qcm (qcm_id, enonce) VALUES
(1, 'Quelle est la valeur de la variable x après l’instruction : x = 3 + 2 * 4 ?');

-- Réponses Question 1 (question_id = 1)
INSERT INTO reponses_qcm (question_id, reponse, is_correct, explications) VALUES
(1, '11', TRUE,  'Priorité de la multiplication : 3 + (2×4) = 11'),
(1, '20', FALSE, 'Erreur : la multiplication a priorité sur l’addition'),
(1, '14', FALSE, 'Erreur de calcul');

-- Question 2
INSERT INTO questions_qcm (qcm_id, enonce) VALUES
(1, 'Quelle structure de contrôle permet de répéter une instruction tant qu’une condition est vraie ?');

-- Réponses Question 2 (question_id = 2)
INSERT INTO reponses_qcm (question_id, reponse, is_correct, explications) VALUES
(2, 'La boucle while', TRUE,  '“while” exécute tant que la condition est vraie.'),
(2, 'L’instruction if', FALSE, 'if ne se répète pas, il s’exécute une seule fois.'),
(2, 'La boucle switch', FALSE, 'switch sert aux tests multiples.');

-- =========================================================
-- QCM 2 : Programmation Web - PHP
-- =========================================================

-- Question 1
INSERT INTO questions_qcm (qcm_id, enonce) VALUES
(2, 'Quelle balise permet d’insérer du code PHP dans une page HTML ?');

-- Réponses Question 1 (question_id = 3)
INSERT INTO reponses_qcm (question_id, reponse, is_correct, explications) VALUES
(3, '<?php ?>', TRUE,  'C’est la balise standard pour le code PHP.'),
(3, '<script php>', FALSE, 'Cette balise n’existe pas.'),
(3, '<php></php>', FALSE,  'Ceci n’est pas valide.');

-- Question 2
INSERT INTO questions_qcm (qcm_id, enonce) VALUES
(2, 'Quelle fonction permet d’afficher du texte en PHP ?');

-- Réponses Question 2 (question_id = 4)
INSERT INTO reponses_qcm (question_id, reponse, is_correct, explications) VALUES
(4, 'echo', TRUE,  'echo permet d’afficher une ou plusieurs chaînes de caractères.'),
(4, 'print', FALSE, 'print fonctionne aussi, mais echo est la plus courante.'),
(4, 'write()', FALSE, 'write() n’existe pas en PHP.');
