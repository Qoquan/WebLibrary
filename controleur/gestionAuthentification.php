<?php
// =========================================================
// Fichier : controleur/gestionAuthentification.php
// Description : Gestion sessions et cookies
// VERSION AVEC COOKIES "SE SOUVENIR DE MOI"
// =========================================================

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// CONNEXION
// ============================================

/**
 * Connecte un utilisateur en stockant son ID dans la session
 * @param int $idUtilisateur ID de l'utilisateur
 */
function connecter_utilisateur($idUtilisateur) {
    $_SESSION['utilisateurId'] = $idUtilisateur;
    
    // Régénérer l'ID de session pour sécurité
    session_regenerate_id(true);
}

// ============================================
// VÉRIFICATION CONNEXION
// ============================================

/**
 * Vérifie si un utilisateur est connecté
 * @return bool True si connecté, False sinon
 */
function est_connecte() {
    return isset($_SESSION['utilisateurId']);
}

/**
 * Retourne l'ID de l'utilisateur connecté
 * @return int|null ID utilisateur ou null
 */
function utilisateur_id() {
    return $_SESSION['utilisateurId'] ?? null;
}

// ============================================
// DÉCONNEXION
// ============================================

/**
 * Déconnecte l'utilisateur et supprime les cookies
 */
function deconnecter_utilisateur() {
    
    // Supprimer le cookie "Se souvenir de moi"
    if (isset($_COOKIE['remember_token'])) {
        
        // Supprimer le token de la BDD
        try {
            require_once __DIR__ . '/../config/config.php';
            
            $dbConf = obtenirConfigBdd();
            $pdo = new PDO(
                "mysql:host={$dbConf['serveur']};dbname={$dbConf['bdd']};charset=utf8mb4",
                $dbConf['utilisateur'],
                $dbConf['mdp'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
            $stmt = $pdo->prepare("
                UPDATE t_utilisateur_uti 
                SET uti_remember_token = NULL, 
                    uti_remember_expiration = NULL
                WHERE uti_id = ?
            ");
            $stmt->execute([utilisateur_id()]);
            
        } catch (Exception $e) {
            // Erreur silencieuse
        }
        
        // Supprimer le cookie du navigateur
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    }
    
    // Détruire la session
    if (session_status() !== PHP_SESSION_NONE) {
        session_unset();
        session_destroy();
    }
    
    // Recréer une session vide
    session_start();
}