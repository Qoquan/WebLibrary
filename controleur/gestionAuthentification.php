<?php
// Toujours démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connecte un utilisateur en stockant son ID
function connecter_utilisateur($idUtilisateur) {
    $_SESSION['utilisateurId'] = $idUtilisateur;
}

// Vérifie si utilisateur connecté
function est_connecte() {
    return isset($_SESSION['utilisateurId']);
}

// Retourne l'ID utilisateur connecté (ou null)
function utilisateur_id() {
    return $_SESSION['utilisateurId'] ?? null;
}

// Déconnexion
function deconnecter_utilisateur() {
    if (session_status() !== PHP_SESSION_NONE) {
        session_unset();
        session_destroy();
    }

    // Recréer la session vide
    session_start();
}