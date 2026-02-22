<?php
$pageTitle = "Mon Profil";
require_once __DIR__ . '/controleur/profil_controleur.php';
require_once __DIR__ . '/header.php';
?>
<link rel="stylesheet" href="asset/style.css">

<main class="profil-page">
    <section class="profil-section">
        <h2>Profil</h2>

        <?php if ($utilisateur) : ?>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['uti_prenom']) ?></p>
            <p><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['uti_nom']) ?></p>
            <p><strong>Pseudo :</strong> <?= htmlspecialchars($utilisateur['uti_pseudo']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['uti_email']) ?></p>
        <?php endif; ?>

        <form method="post">
            <button type="submit" name="logout" class="btn-deconnexion">Déconnexion</button>
        </form>

    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>