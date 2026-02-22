<?php
// =========================================================
// Fichier : core/gestionBdd.php
// Description : Gestion de la connexion à la base de données
// =========================================================

// Import du fichier de configuration
require_once __DIR__ . '/../Config/config.php';

/**
 * Crée et retourne une connexion PDO à la base de données.
 *
 * @param string $nomBDD Nom de la base de données à laquelle se connecter.
 * @return PDO Objet PDO prêt à exécuter des requêtes SQL.
 * @throws PDOException Si une erreur survient lors de la connexion.
 */
function obtenirConnexionBdd(string $nomBDD): PDO {
    // Récupération de la configuration
    $config = obtenirConfigBdd();

    // Construction dynamique du DSN (Data Source Name)
    $dsn = "mysql:host={$config['serveur']};dbname={$nomBDD};charset=utf8";

    try {
        // Création de la connexion PDO
        $pdo = new PDO($dsn, $config['utilisateur'], $config['mdp'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lève des exceptions en cas d’erreur
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retourne les résultats sous forme de tableaux associatifs
            PDO::ATTR_EMULATE_PREPARES => false // Désactive l’émulation des requêtes préparées
        ]);

        return $pdo;
    } catch (PDOException $e) {
        // Si le mode dev est activé, afficher l’erreur
        if (defined('DEV_MODE') && DEV_MODE) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        } else {
            // En production, on ne montre pas le message d’erreur exact
            die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
        }
    }
}
