<?php
require_once __DIR__ . '/../config/config.php';

$erreurs = [];
$formMessage = "";

// Fonction pour récupérer une valeur post et l'afficher dans le formulaire
function e($champ) {
    return htmlspecialchars($_POST[$champ] ?? '', ENT_QUOTES, 'UTF-8');
}

// Si on a soumis le formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération
    $prenom = trim($_POST["prenom"] ?? "");
    $nom = trim($_POST["nom"] ?? "");
    $pseudo = trim($_POST["pseudo"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $motDePasse = $_POST["motDePasse"] ?? "";
    $motDePasseConfirme = $_POST["motDePasseConfirme"] ?? "";

    // --- VALIDATION ---
    if ($pseudo === "") $erreurs["pseudo"] = "Le pseudo est obligatoire.";
    if ($email === "") $erreurs["email"] = "L'email est obligatoire.";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs["email"] = "Adresse email invalide.";
    }

    if (strlen($motDePasse) < 6) {
        $erreurs["motDePasse"] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    if ($motDePasse !== $motDePasseConfirme) {
        $erreurs["motDePasseConfirme"] = "Les mots de passe ne correspondent pas.";
    }

    // Si erreurs, on arrête
    if (!empty($erreurs)) return;

    // Connexion à la BDD
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
        die("Erreur connexion SQL : " . $e->getMessage());
    }

    // Vérifier doublons pseudo/email
    $stmt = $pdo->prepare("
        SELECT uti_id FROM t_utilisateur_uti 
        WHERE uti_pseudo = ? OR uti_email = ?
    ");
    $stmt->execute([$pseudo, $email]);

    if ($stmt->fetch()) {
        $erreurs["email"] = "Pseudo ou email déjà utilisé.";
        return;
    }

    // Hash du mot de passe
    $hash = password_hash($motDePasse, PASSWORD_DEFAULT);

  // NOUVEAU CODE (sans prénom/nom)
$stmt = $pdo->prepare("
    INSERT INTO t_utilisateur_uti
    (uti_prenom, uti_nom, uti_pseudo, uti_email, uti_motdepasse, uti_compte_active, uti_code_activation)
    VALUES (?, ?, ?, ?, ?, 1, NULL)
");

$stmt->execute([
    $prenom,
    $nom,
    $pseudo,
    $email,
    $hash
]);

    $formMessage = "<p class='success'>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>";
}