<?php
// =========================================================
// Fichier : controleur/bibliotheque_controleur.php
// Description : Contrôleur bibliothèque avec notes/commentaires
// VERSION CORRIGÉE
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
    die("Erreur connexion BDD : " . $e->getMessage());
}

// ============================================
// ENREGISTREMENT NOTE ET COMMENTAIRE
// ============================================
if (isset($_POST['enregistrer_note']) && isset($_POST['livre_id'])) {
    
    $livreId = (int) $_POST['livre_id'];
    $note = isset($_POST['note']) ? (int) $_POST['note'] : null;
    $commentaire = trim($_POST['commentaire'] ?? '');
    $userId = utilisateur_id();
    
    // Validation de la note (0 à 5)
    if ($note !== null && ($note < 0 || $note > 5)) {
        $messageSucces = "❌ La note doit être entre 0 et 5.";
    } else {
        try {
            // Mise à jour de la note et du commentaire
            $stmt = $pdo->prepare("
                UPDATE t_livre_liv 
                SET liv_note_personnelle = ?, 
                    liv_commentaire_personnel = ?
                WHERE liv_id = ? 
                AND liv_utilisateur_id = ?
            ");
            
            $result = $stmt->execute([
                $note,
                $commentaire ?: null,
                $livreId,
                $userId
            ]);
            
            if ($result) {
                if ($note > 0 || !empty($commentaire)) {
                    $messageSucces = "✅ Note et commentaire enregistrés avec succès !";
                } else {
                    $messageSucces = "✅ Note et commentaire supprimés.";
                }
            } else {
                $messageSucces = "❌ Erreur lors de l'enregistrement.";
            }
            
        } catch (PDOException $e) {
            $messageSucces = "❌ Erreur : " . $e->getMessage();
        }
    }
}

// ============================================
// SUPPRESSION D'UN LIVRE
// ============================================
if (isset($_POST['supprimer_id']) && !isset($_POST['enregistrer_note'])) {
    $livreId = (int) $_POST['supprimer_id'];
    $userId = utilisateur_id();
    
    try {
        $stmt = $pdo->prepare("DELETE FROM t_livre_liv WHERE liv_id = ? AND liv_utilisateur_id = ?");
        $stmt->execute([$livreId, $userId]);
        
        $messageSucces = "✅ Livre supprimé avec succès !";
    } catch (PDOException $e) {
        $messageSucces = "❌ Erreur lors de la suppression : " . $e->getMessage();
    }
}

// ============================================
// AJOUT D'UN LIVRE MANUEL
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['titre']) 
    && !isset($_POST['enregistrer_note']) 
    && !isset($_POST['supprimer_id'])) {
    
    $titre = trim($_POST['titre'] ?? '');
    $auteur = trim($_POST['auteur'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    // Validation
    if (empty($titre)) {
        $erreurs['titre'] = "Le titre est obligatoire.";
    } elseif (mb_strlen($titre) < 2 || mb_strlen($titre) > 500) {
        $erreurs['titre'] = "Le titre doit contenir entre 2 et 500 caractères.";
    }
    
    if (empty($auteur)) {
        $erreurs['auteur'] = "L'auteur est obligatoire.";
    } elseif (mb_strlen($auteur) < 2 || mb_strlen($auteur) > 255) {
        $erreurs['auteur'] = "L'auteur doit contenir entre 2 et 255 caractères.";
    }
    
    // Si pas d'erreurs, insertion
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO t_livre_liv 
                (liv_titre, liv_auteur, liv_description, liv_utilisateur_id) 
                VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $titre, 
                $auteur, 
                $description ?: null, 
                utilisateur_id()
            ]);
            
            $messageSucces = "✅ Livre ajouté avec succès !";
            $_POST = []; // Vider le formulaire
            
        } catch (PDOException $e) {
            $messageSucces = "❌ Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}

// ============================================
// RÉCUPÉRATION DES LIVRES
// ============================================
try {
    $stmt = $pdo->prepare("
        SELECT * FROM t_livre_liv 
        WHERE liv_utilisateur_id = ? 
        ORDER BY liv_date_ajout DESC
    ");
    $stmt->execute([utilisateur_id()]);
    $livres = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $messageSucces = "❌ Erreur lors de la récupération des livres : " . $e->getMessage();
    $livres = [];
}