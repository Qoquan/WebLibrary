<?php
require_once __DIR__ . '/gestionAuthentification.php';
require_once __DIR__ . '/../config/config.php';

// Redirection si NON connecté
if (!est_connecte()) {
    header("Location: connexion.php");
    exit();
}

$utilisateur = null;

// Connexion à la BDD
$dbConf = obtenirConfigBdd();

$pdo = new PDO(
    "mysql:host={$dbConf['serveur']};dbname={$dbConf['bdd']};charset=utf8mb4",
    $dbConf['utilisateur'],
    $dbConf['mdp'],
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

// Récupération des infos utilisateur
$stmt = $pdo->prepare("SELECT uti_prenom, uti_nom, uti_pseudo, uti_email FROM t_utilisateur_uti WHERE uti_id = ?");
$stmt->execute([utilisateur_id()]);
$utilisateur = $stmt->fetch();

// Déconnexion
if (isset($_POST['logout'])) {
    deconnecter_utilisateur();
    header("Location: connexion.php");
    exit();
}