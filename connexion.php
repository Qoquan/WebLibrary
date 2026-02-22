<?php
$pageTitle = "Connexion";
require_once __DIR__ . '/controleur/connexion_controleur.php';
require_once __DIR__ . '/header.php';



// Créer un cookie durable
function definir_cookie($nom, $valeur, $duree = 31536000) {
    setcookie($nom, $valeur, time() + $duree, "/", "", false, true);
}

// Lire un cookie
function lire_cookie($nom) {
    return $_COOKIE[$nom] ?? null;
}

// Supprimer un cookie
function supprimer_cookie($nom) {
    setcookie($nom, "", time() - 3600, "/");
}?>
<link rel="stylesheet" href="asset/style.css">

<main class="connexion-page">
    <section class="connexion-section">
        <h2>Connexion</h2>

        <form method="post">

            <label for="pseudo">Pseudo :</label>
            <input 
                type="text" 
                id="pseudo" 
                name="pseudo" 
                value="<?= e('pseudo') ?>" 
                required
            >
            <p class="erreur"><?= $erreurs['pseudo'] ?? '' ?></p>

            <label for="motDePasse">Mot de passe :</label>
            <input 
                type="password" 
                id="motDePasse" 
                name="motDePasse" 
                required
            >
            <p class="erreur"><?= $erreurs['motDePasse'] ?? '' ?></p>

            <div class="buttons">
                <input id="sub" type="submit" value="Connexion">
            </div>

        </form>

        <!-- Lien vers inscription -->
        <a href="inscription.php">Pas encore de compte ? Inscrivez-vous</a>

        <!-- Message d'erreur -->
        <p class="erreur"><?= $formMessage ?></p>

    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>