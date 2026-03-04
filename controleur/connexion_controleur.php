<?php
// =========================================================
// Fichier : controleur/connexion_controleur.php
// Description : Connexion avec cookies "Se souvenir de moi"
// =========================================================

require_once __DIR__ . '/gestionAuthentification.php';
require_once __DIR__ . '/../config/config.php';

$erreurs = [];
$formMessage = "";

// Fonction simple de récupération de champs
function e($champ) {
    return htmlspecialchars($_POST[$champ] ?? '', ENT_QUOTES, 'UTF-8');
}

// ============================================
// VÉRIFICATION COOKIE AUTO-CONNEXION
// ============================================
if (!est_connecte() && isset($_COOKIE['remember_token'])) {
    
    $token = $_COOKIE['remember_token'];
    
    // Connexion BDD
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
    
    // Chercher l'utilisateur avec ce token
    $stmt = $pdo->prepare("
        SELECT uti_id 
        FROM t_utilisateur_uti 
        WHERE uti_remember_token = ? 
        AND uti_remember_expiration > NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        // Token valide : connexion automatique
        connecter_utilisateur($user['uti_id']);
        header("Location: profil.php");
        exit();
    } else {
        // Token invalide ou expiré : supprimer le cookie
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    }
}

// Si déjà connecté → profil
if (est_connecte()) {
    header("Location: profil.php");
    exit();
}

// ============================================
// TRAITEMENT DU FORMULAIRE DE CONNEXION
// ============================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pseudo = trim($_POST["pseudo"] ?? "");
    $motDePasse = $_POST["motDePasse"] ?? "";
    $seRappeler = isset($_POST["se_souvenir"]) && $_POST["se_souvenir"] == "1";

    // Validation
    if ($pseudo === "") {
        $erreurs["pseudo"] = "Veuillez entrer un pseudo.";
    }

    if ($motDePasse === "") {
        $erreurs["motDePasse"] = "Veuillez entrer un mot de passe.";
    }

    if (!empty($erreurs)) return;

    // Connexion SQL
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

    // Recherche utilisateur
    $stmt = $pdo->prepare("
        SELECT uti_id, uti_motdepasse 
        FROM t_utilisateur_uti 
        WHERE uti_pseudo = ?
    ");
    $stmt->execute([$pseudo]);
    $user = $stmt->fetch();

    if (!$user) {
        $formMessage = "Pseudo ou mot de passe incorrect.";
        return;
    }

    // Vérification mot de passe
    if (!password_verify($motDePasse, $user["uti_motdepasse"])) {
        $formMessage = "Pseudo ou mot de passe incorrect.";
        return;
    }

    // ============================================
    // CONNEXION RÉUSSIE
    // ============================================
    
    connecter_utilisateur($user["uti_id"]);

    // ============================================
    // GESTION DU COOKIE "SE SOUVENIR DE MOI"
    // ============================================
    
    if ($seRappeler) {
        
        // Générer un token unique et sécurisé
        $token = bin2hex(random_bytes(32)); // 64 caractères hexadécimaux
        
        // Date d'expiration : 1 semaine (7 jours)
        $expiration = date('Y-m-d H:i:s', time() + (7 * 24 * 60 * 60));
        
        // Sauvegarder le token en BDD
        $stmt = $pdo->prepare("
            UPDATE t_utilisateur_uti 
            SET uti_remember_token = ?, 
                uti_remember_expiration = ?
            WHERE uti_id = ?
        ");
        $stmt->execute([$token, $expiration, $user["uti_id"]]);
        
        // Créer le cookie (7 jours, httponly, samesite)
        setcookie(
            'remember_token',           // Nom
            $token,                      // Valeur (token)
            time() + (7 * 24 * 60 * 60), // Expiration (7 jours)
            '/',                         // Path (tout le site)
            '',                          // Domain (laisser vide = domaine actuel)
            false,                       // Secure (true si HTTPS)
            true                         // HttpOnly (protection XSS)
        );
    }

    // Cookie pour mémoriser le pseudo (optionnel)
    setcookie("dernier_pseudo", $pseudo, time() + (30 * 24 * 60 * 60), '/');

    header("Location: profil.php");
    exit();
}