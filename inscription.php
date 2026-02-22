<?php
$pageTitle = "Inscription";
$metaDescription = "Page d'inscription de mon site web.";
require_once __DIR__ . '/controleur/inscription_controleur.php';
require_once __DIR__ . '/header.php';
?>
<link rel="stylesheet" href="asset/style.css">

<main class="inscription-page">
    <section class="inscription-section">
        <h2>Inscription</h2>

        <form method="post" novalidate>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" 
                value="<?= e('prenom') ?>" 
                class="<?= isset($erreurs['prenom']) ? 'erreur-champ' : '' ?>" required>
            <p class="erreur"><?= $erreurs['prenom'] ?? '' ?></p>

            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" 
                value="<?= e('nom') ?>" 
                class="<?= isset($erreurs['nom']) ? 'erreur-champ' : '' ?>" required>
            <p class="erreur"><?= $erreurs['nom'] ?? '' ?></p>

            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" 
                value="<?= e('pseudo') ?>" 
                class="<?= isset($erreurs['pseudo']) ? 'erreur-champ' : '' ?>" required>
            <p class="erreur"><?= $erreurs['pseudo'] ?? '' ?></p>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" 
                value="<?= e('email') ?>" 
                class="<?= isset($erreurs['email']) ? 'erreur-champ' : '' ?>" required>
            <p class="erreur"><?= $erreurs['email'] ?? '' ?></p>

            <label for="motDePasse">Mot De Passe :</label>
            <input type="password" id="motDePasse" name="motDePasse"
                value="<?= e('motDePasse') ?>"
                class="<?= isset($erreurs['motDePasse']) ? 'erreur-champ' : '' ?>" required>
            <p class="erreur"><?= $erreurs['motDePasse'] ?? '' ?></p>

            <label for="motDePasseConfirme">Confirmation du mot de passe :</label>
            <input type="password" id="motDePasseConfirme" name="motDePasseConfirme"
                value="<?= e('motDePasseConfirme') ?>"
                class="<?= isset($erreurs['motDePasseConfirme']) ? 'erreur-champ' : '' ?>" required>
            <p class="erreur"><?= $erreurs['motDePasseConfirme'] ?? '' ?></p>


            <div class="buttons">
                <input id="sub" type="submit" value="Envoyer">
                <input id="reset" type="reset" value="Réinitialiser">

        </form>

        <?= $formMessage ?>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>