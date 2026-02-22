
<?php

$pageTitle = "Contact";
$metaDescription = "Page de contact de mon site web.";


require_once __DIR__ . '/controleur/contact_controler.php';
require_once __DIR__ . '/header.php';
?>

<link rel="stylesheet" href="asset/style.css">

<main class="contact-page">
    <section class="contact-section">
        <h2>Contact</h2>

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

            <label for="message">Message :</label>
            <textarea id="message" name="message" 
                    class="<?= isset($erreurs['message']) ? 'erreur-champ' : '' ?>" required><?= e('message') ?></textarea>
            <p class="erreur"><?= $erreurs['message'] ?? '' ?></p>

            <div class="buttons">
                <input id="sub" type="submit" value="Envoyer">
                <input id="reset" type="reset" value="Réinitialiser">
            </div>
        </form>

        <?= $formMessage ?>
    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>