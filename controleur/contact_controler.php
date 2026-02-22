<?php
// =========================================================
// Fichier : controleur/contact_controler.php
// Description : Contrôleur du formulaire de contact
// AMÉLIORÉ : Sauvegarde en base de données
// =========================================================

require_once __DIR__ . '/../config/config.php';

// Fonction d'échappement HTML
function e(string $name): string {
    return htmlspecialchars($_POST[$name] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Fonction de nettoyage
function nettoyer(string $valeur): string {
    return trim($valeur);
}

// Vérifier si champ rempli
function estRempli(string $valeur): bool {
    return $valeur !== '';
}

// Vérifier email valide
function estEmailValide(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Vérifier longueur
function longueurOk(string $texte, int $min, int $max): bool {
    $len = mb_strlen($texte);
    return $len >= $min && $len <= $max;
}

// Variables
$erreurs = [];
$formMessage = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $prenom = nettoyer($_POST['prenom'] ?? '');
    $nom = nettoyer($_POST['nom'] ?? '');
    $pseudo = nettoyer($_POST['pseudo'] ?? '');
    $email = nettoyer($_POST['email'] ?? '');
    $message = nettoyer($_POST['message'] ?? '');

    // === VALIDATION ===
    
    if (!estRempli($prenom)) {
        $erreurs['prenom'] = "Le prénom est obligatoire.";
    } elseif (!longueurOk($prenom, 2, 255)) {
        $erreurs['prenom'] = "Le prénom doit contenir entre 2 et 255 caractères.";
    }

    if (!estRempli($nom)) {
        $erreurs['nom'] = "Le nom est obligatoire.";
    } elseif (!longueurOk($nom, 2, 255)) {
        $erreurs['nom'] = "Le nom doit contenir entre 2 et 255 caractères.";
    }

    if (!estRempli($pseudo)) {
        $erreurs['pseudo'] = "Le pseudo est obligatoire.";
    } elseif (!longueurOk($pseudo, 2, 50)) {
        $erreurs['pseudo'] = "Le pseudo doit contenir entre 2 et 50 caractères.";
    }

    if (!estRempli($email)) {
        $erreurs['email'] = "L'email est obligatoire.";
    } elseif (!estEmailValide($email)) {
        $erreurs['email'] = "L'adresse email n'est pas valide.";
    }

    if (!estRempli($message)) {
        $erreurs['message'] = "Le message est obligatoire.";
    } elseif (!longueurOk($message, 10, 3000)) {
        $erreurs['message'] = "Le message doit contenir entre 10 et 3000 caractères.";
    }

    // === SAUVEGARDE EN BASE DE DONNÉES ===
    
    if (empty($erreurs)) {
        try {
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

            // Insertion dans la table t_contact_con
            $stmt = $pdo->prepare("
                INSERT INTO t_contact_con 
                (con_prenom, con_nom, con_pseudo, con_email, con_message) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([$prenom, $nom, $pseudo, $email, $message]);

            // Message de succès
            $formMessage = "<p class='success'>✅ Message envoyé avec succès !</p>";
            
            // Vider le formulaire
            $_POST = [];
            
        } catch (PDOException $e) {
            $formMessage = "<p class='erreur'>❌ Erreur lors de l'envoi : " . $e->getMessage() . "</p>";
        }
    }
}