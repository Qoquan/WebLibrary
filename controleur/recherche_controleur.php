<?php
// =========================================================
// Fichier : controleur/recherche_controleur.php
// Description : Recherche de livres via l'API Google Books
// =========================================================

require_once __DIR__ . '/gestionAuthentification.php';
require_once __DIR__ . '/../config/config.php';

// Redirection si NON connecté
if (!est_connecte()) {
    header("Location: connexion.php");
    exit();
}

$resultats = [];
$messageSucces = '';
$messageErreur = '';

/**
 * Rechercher des livres via l'API Google Books
 * @param string $recherche Terme de recherche
 * @return array Tableau de livres trouvés
 */
function rechercherLivresGoogleBooks($recherche) {
    // URL de l'API Google Books
    // Pas besoin de clé API pour les recherches basiques !
    $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($recherche) . '&maxResults=20&langRestrict=fr';
    
    // Effectuer la requête
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 5,
            'header' => 'User-Agent: Mozilla/5.0'
        ]
    ]);
    
    $reponse = @file_get_contents($url, false, $context);
    
    if ($reponse === false) {
        return [];
    }
    
    $data = json_decode($reponse, true);
    
    if (empty($data['items'])) {
        return [];
    }
    
    // Formater les résultats
    $livres = [];
    foreach ($data['items'] as $item) {
        $volumeInfo = $item['volumeInfo'] ?? [];
        
        $livres[] = [
            'titre' => $volumeInfo['title'] ?? 'Sans titre',
            'auteur' => isset($volumeInfo['authors']) ? implode(', ', $volumeInfo['authors']) : 'Auteur inconnu',
            'description' => $volumeInfo['description'] ?? '',
            'editeur' => $volumeInfo['publisher'] ?? '',
            'date_publication' => $volumeInfo['publishedDate'] ?? '',
            'image' => $volumeInfo['imageLinks']['thumbnail'] ?? '',
            'isbn' => isset($volumeInfo['industryIdentifiers'][0]) 
                ? $volumeInfo['industryIdentifiers'][0]['identifier'] 
                : ''
        ];
    }
    
    return $livres;
}

// === RECHERCHE DE LIVRES ===
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $recherche = trim($_GET['q']);
    $resultats = rechercherLivresGoogleBooks($recherche);
}

// === AJOUT D'UN LIVRE À LA BIBLIOTHÈQUE ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_livre'])) {
    
    $titre = trim($_POST['titre'] ?? '');
    $auteur = trim($_POST['auteur'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $editeur = trim($_POST['editeur'] ?? '');
    $datePublication = trim($_POST['date_publication'] ?? '');
    $imageUrl = trim($_POST['image_url'] ?? '');
    
    if (empty($titre) || empty($auteur)) {
        $messageErreur = "❌ Titre et auteur requis.";
    } else {
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
            
            // Vérifier si le livre n'existe pas déjà pour cet utilisateur
            $stmt = $pdo->prepare("
                SELECT COUNT(*) FROM t_livre_liv 
                WHERE liv_titre = ? 
                AND liv_auteur = ? 
                AND liv_utilisateur_id = ?
            ");
            $stmt->execute([$titre, $auteur, utilisateur_id()]);
            
            if ($stmt->fetchColumn() > 0) {
                $messageErreur = "❌ Ce livre est déjà dans votre bibliothèque.";
            } else {
                // Insérer le livre
                $stmt = $pdo->prepare("
                    INSERT INTO t_livre_liv 
                    (liv_titre, liv_auteur, liv_description, liv_editeur, 
                     liv_date_publication, liv_image_url, liv_utilisateur_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                
                $stmt->execute([
                    $titre,
                    $auteur,
                    $description ?: null,
                    $editeur ?: null,
                    $datePublication ?: null,
                    $imageUrl ?: null,
                    utilisateur_id()
                ]);
                
                $messageSucces = "✅ Livre ajouté à votre bibliothèque !";
            }
            
        } catch (PDOException $e) {
            $messageErreur = "❌ Erreur : " . $e->getMessage();
        }
    }
}