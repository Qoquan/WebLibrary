<?php

// =========================================================
// Fichier : config/config.php
// Description : Configuration de base du projet PHP
// =========================================================

// --- Activer le mode développement ---
define('DEV_MODE', true);

// --- Affichage des erreurs ---
if (DEV_MODE) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}

/**
 * Retourne la configuration de la base de données.
 *
 * @return array Tableau associatif contenant les paramètres de connexion.
 */
function obtenirConfigBdd(): array {
    return [
        'serveur'     => 'localhost',
        'bdd'         => 'bdd_projet_web',  // <-- CORRECTION ICI
        'utilisateur' => 'root',
        'mdp'         => ''
    ];
}