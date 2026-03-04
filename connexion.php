<?php
$pageTitle = "Connexion";
require_once __DIR__ . '/controleur/connexion_controleur.php';
require_once __DIR__ . '/header.php';
?>

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

            <!-- Checkbox "Se souvenir de moi" -->
            <div style="margin: 15px 0;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer;">
                    <input 
                        type="checkbox" 
                        name="se_souvenir" 
                        id="se_souvenir"
                        value="1"
                        style="width: auto; margin: 0; cursor: pointer;"
                    >
                    <span>🍪 Se souvenir de moi pendant 1 semaine</span>
                </label>
            </div>

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