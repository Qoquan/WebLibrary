<?php
// =========================================================
// Fichier : controleur/bibliotheque_controleur.php
// Description : Contrôleur de la page bibliothèque
// AVEC NOTES ET COMMENTAIRES - VERSION CORRIGÉE
// =========================================================

require_once __DIR__ . '/gestionAuthentification.php';
require_once __DIR__ . '/../config/config.php';

// Redirection si NON connecté
if (!est_connecte()) {
    header("Location: connexion.php");
    exit();
}

$erreurs = [];
$messageSucces = '';
$livres = [];

// Connexion BDD
$dbConf = obtenirConfigBdd();

try {
    $pdo = new PDO(
        "mysql:host={$dbConf['serveur']};dbname={$dbConf['bdd']};charset=utf8mb4",
        $dbConf['utilisateur'],
        $dbConf['mdp'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage()