<?php
// =========================================================
// Fichier : api/statistiques.php
// Description : API REST pour récupérer les statistiques
// Retourne du JSON pour Fetch API
// =========================================================

// Headers pour API JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once __DIR__ . '/../controleur/gestionAuthentification.php';
require_once __DIR__ . '/../config/config.php';

// Vérifier la connexion
if (!est_connecte()) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Utilisateur non connecté'
    ]);
    exit();
}

$userId = utilisateur_id();

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
    
    // =========================================
    // 1. STATISTIQUES GÉNÉRALES
    // =========================================
    
    // Total de livres
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ?
    ");
    $stmt->execute([$userId]);
    $totalLivres = (int)$stmt->fetch()['total'];
    
    // Note moyenne
    $stmt = $pdo->prepare("
        SELECT AVG(liv_note_personnelle) as moyenne 
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ? 
        AND liv_note_personnelle IS NOT NULL
    ");
    $stmt->execute([$userId]);
    $noteMoyenne = round($stmt->fetch()['moyenne'] ?? 0, 1);
    
    // Livres commentés
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ? 
        AND liv_commentaire_personnel IS NOT NULL 
        AND liv_commentaire_personnel != ''
    ");
    $stmt->execute([$userId]);
    $livresCommentes = (int)$stmt->fetch()['total'];
    
    // Livres ajoutés ce mois-ci
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ? 
        AND MONTH(liv_date_ajout) = MONTH(CURRENT_DATE())
        AND YEAR(liv_date_ajout) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute([$userId]);
    $livresMoisCourant = (int)$stmt->fetch()['total'];
    
    // =========================================
    // 2. RÉPARTITION PAR NOTE
    // =========================================
    
    $stmt = $pdo->prepare("
        SELECT 
            COALESCE(liv_note_personnelle, 0) as note,
            COUNT(*) as nombre
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ?
        GROUP BY liv_note_personnelle
        ORDER BY note
    ");
    $stmt->execute([$userId]);
    $repartitionNotes = $stmt->fetchAll();
    
    // Préparer les données pour Chart.js (0-5 étoiles)
    $notesData = array_fill(0, 6, 0); // [0, 0, 0, 0, 0, 0]
    foreach ($repartitionNotes as $item) {
        $note = (int)$item['note'];
        $notesData[$note] = (int)$item['nombre'];
    }
    
    // =========================================
    // 3. ÉVOLUTION MENSUELLE (6 derniers mois)
    // =========================================
    
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(liv_date_ajout, '%Y-%m') as mois,
            DATE_FORMAT(liv_date_ajout, '%M %Y') as mois_libelle,
            COUNT(*) as nombre
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ?
        AND liv_date_ajout >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH)
        GROUP BY mois, mois_libelle
        ORDER BY mois
    ");
    $stmt->execute([$userId]);
    $evolution = $stmt->fetchAll();
    
    $moisLabels = [];
    $moisData = [];
    foreach ($evolution as $item) {
        $moisLabels[] = $item['mois_libelle'];
        $moisData[] = (int)$item['nombre'];
    }
    
    // =========================================
    // 4. TOP 10 AUTEURS
    // =========================================
    
    $stmt = $pdo->prepare("
        SELECT 
            liv_auteur as auteur,
            COUNT(*) as nombre
        FROM t_livre_liv 
        WHERE liv_utilisateur_id = ?
        AND liv_auteur IS NOT NULL
        AND liv_auteur != ''
        GROUP BY liv_auteur
        ORDER BY nombre DESC
        LIMIT 10
    ");
    $stmt->execute([$userId]);
    $topAuteurs = $stmt->fetchAll();
    
    $auteursLabels = [];
    $auteursData = [];
    foreach ($topAuteurs as $item) {
        $auteursLabels[] = $item['auteur'];
        $auteursData[] = (int)$item['nombre'];
    }
    
    // =========================================
    // RÉPONSE JSON
    // =========================================
    
    $response = [
        'success' => true,
        'data' => [
            'general' => [
                'totalLivres' => $totalLivres,
                'noteMoyenne' => $noteMoyenne,
                'livresCommentes' => $livresCommentes,
                'livresMoisCourant' => $livresMoisCourant
            ],
            'notes' => [
                'labels' => ['0⭐', '1⭐', '2⭐', '3⭐', '4⭐', '5⭐'],
                'data' => $notesData
            ],
            'evolution' => [
                'labels' => $moisLabels,
                'data' => $moisData
            ],
            'auteurs' => [
                'labels' => $auteursLabels,
                'data' => $auteursData
            ]
        ]
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erreur base de données : ' . $e->getMessage()
    ]);
}