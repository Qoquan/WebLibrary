<?php
require_once __DIR__ . '/gestionAuthentification.php';
require_once __DIR__ . '/../config/config.php';

$erreurs = [];
$formMessage = "";

// Fonction simple de récupération de champs
function e($champ) {
    return htmlspecialchars($_POST[$champ] ?? '', ENT_QUOTES, 'UTF-8');
}

// Si déjà connecté → profil
if (est_connecte()) {
    header("Location: profil.php");
    exit();
}

// Si formulaire envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pseudo = trim($_POST["pseudo"] ?? "");
    $motDePasse = $_POST["motDePasse"] ?? "";

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
    $stmt = $pdo->prepare("SELECT uti_id, uti_motdepasse FROM t_utilisateur_uti WHERE uti_pseudo = ?");
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

    // Connexion OK
    connecter_utilisateur($user["uti_id"]);

    // Cookie pour mémoriser le pseudo
    setcookie("dernier_pseudo", $pseudo, time() + (3600 * 24 * 30));

    header("Location: profil.php");
    exit();
}