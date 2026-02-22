<?php
// =========================================================
// Fichier : deconnexion.php
// Description : Déconnexion de l'utilisateur
// =========================================================

require_once __DIR__ . '/controleur/gestionAuthentification.php';

// Déconnexion
deconnecter_utilisateur();

// Redirection vers page d'accueil
header("Location: index.php");
exit();