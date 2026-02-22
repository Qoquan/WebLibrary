-- =========================================================
-- BASE DE DONNÉES COMPLÈTE - PROJET BIBLIOTHÈQUE
-- Fichier SQL complet avec toutes les tables
-- =========================================================

-- Supprimer la base si elle existe (ATTENTION : perte de données)
-- DROP DATABASE IF EXISTS bdd_projet_web;

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS bdd_projet_web 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE bdd_projet_web;

-- =========================================================
-- SUPPRESSION DES TABLES (dans le bon ordre)
-- =========================================================

DROP TABLE IF EXISTS t_livre_liv;
DROP TABLE IF EXISTS t_contact_con;
DROP TABLE IF EXISTS t_utilisateur_uti;

-- =========================================================
-- TABLE 1 : UTILISATEURS
-- =========================================================

CREATE TABLE t_utilisateur_uti (
    uti_id INT AUTO_INCREMENT PRIMARY KEY,
    uti_prenom VARCHAR(255) NOT NULL,
    uti_nom VARCHAR(255) NOT NULL,
    uti_pseudo VARCHAR(255) NOT NULL UNIQUE,
    uti_email VARCHAR(255) NOT NULL UNIQUE,
    uti_motdepasse VARCHAR(255) NOT NULL,
    uti_compte_active TINYINT(1) DEFAULT 1,
    uti_code_activation VARCHAR(5) NULL,
    uti_date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_pseudo (uti_pseudo),
    INDEX idx_email (uti_email)
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- TABLE 2 : LIVRES (avec notes et commentaires)
-- =========================================================

CREATE TABLE t_livre_liv (
    liv_id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- Informations de base
    liv_titre VARCHAR(500) NOT NULL,
    liv_auteur VARCHAR(255) NOT NULL,
    liv_description TEXT,
    
    -- Informations de l'API Google Books
    liv_editeur VARCHAR(255),
    liv_date_publication VARCHAR(50),
    liv_image_url VARCHAR(500),
    liv_isbn VARCHAR(50),
    
    -- Notes et commentaires personnels
    liv_note_personnelle INT DEFAULT NULL COMMENT 'Note de 0 à 5 étoiles',
    liv_commentaire_personnel TEXT DEFAULT NULL COMMENT 'Commentaire personnel',
    
    -- Relation et dates
    liv_utilisateur_id INT NOT NULL,
    liv_date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Clés étrangères
    FOREIGN KEY (liv_utilisateur_id) 
        REFERENCES t_utilisateur_uti(uti_id) 
        ON DELETE CASCADE,
    
    -- Index pour performances
    INDEX idx_utilisateur (liv_utilisateur_id),
    INDEX idx_titre (liv_titre)
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- TABLE 3 : CONTACTS
-- =========================================================

CREATE TABLE t_contact_con (
    con_id INT AUTO_INCREMENT PRIMARY KEY,
    con_prenom VARCHAR(255) NOT NULL,
    con_nom VARCHAR(255) NOT NULL,
    con_pseudo VARCHAR(50) NOT NULL,
    con_email VARCHAR(255) NOT NULL,
    con_message TEXT NOT NULL,
    con_date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_date (con_date_envoi)
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- VÉRIFICATION DE LA STRUCTURE
-- =========================================================

-- Afficher toutes les tables
SHOW TABLES;

-- Afficher la structure de chaque table
DESCRIBE t_utilisateur_uti;
DESCRIBE t_livre_liv;
DESCRIBE t_contact_con;

-- =========================================================
-- DONNÉES DE TEST (Optionnel - Décommenter si besoin)
-- =========================================================

/*
-- Utilisateur de test (mot de passe : test123)
INSERT INTO t_utilisateur_uti (uti_prenom, uti_nom, uti_pseudo, uti_email, uti_motdepasse)
VALUES ('Jean', 'Dupont', 'jeandupont', 'jean@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Livre de test
INSERT INTO t_livre_liv (liv_titre, liv_auteur, liv_description, liv_utilisateur_id, liv_note_personnelle, liv_commentaire_personnel)
VALUES ('Le Petit Prince', 'Antoine de Saint-Exupéry', 'Un conte poétique et philosophique', 1, 5, 'Un chef-d\'œuvre absolu !');

-- Contact de test
INSERT INTO t_contact_con (con_prenom, con_nom, con_pseudo, con_email, con_message)
VALUES ('Marie', 'Martin', 'marie123', 'marie@test.com', 'Bonjour, ceci est un message de test.');
*/

-- =========================================================
-- REQUÊTES UTILES POUR LA MAINTENANCE
-- =========================================================

-- Compter les utilisateurs
-- SELECT COUNT(*) as nb_utilisateurs FROM t_utilisateur_uti;

-- Compter les livres
-- SELECT COUNT(*) as nb_livres FROM t_livre_liv;

-- Compter les contacts
-- SELECT COUNT(*) as nb_contacts FROM t_contact_con;

-- Voir les livres avec notes
-- SELECT liv_titre, liv_auteur, liv_note_personnelle FROM t_livre_liv WHERE liv_note_personnelle IS NOT NULL;

-- Moyenne des notes
-- SELECT AVG(liv_note_personnelle) as note_moyenne FROM t_livre_liv WHERE liv_note_personnelle IS NOT NULL;

-- =========================================================
-- FIN DU SCRIPT SQL
-- =========================================================

-- Messages de confirmation
SELECT 'Base de données créée avec succès !' as message;
SELECT 'Tables créées : t_utilisateur_uti, t_livre_liv, t_contact_con' as info;