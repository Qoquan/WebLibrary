<?php
$pageTitle = "Accueil";
$metaDescription = "Page d'accueil de mon site web personnel.";
require_once __DIR__ . '/header.php';
?>

<main>
    <section>
        <h2>Bienvenue sur mon site web!</h2>
<p>
Ce site est une librairie personnelle qui me permet de gérer et organiser les livres que je souhaite conserver dans ma collection. Les livres peuvent être ajoutés automatiquement grâce à l’import depuis l’API Google Books ou créés manuellement lorsque les informations ne sont pas disponibles.
</p>

<p>
Chaque livre peut ensuite être évalué grâce à un système de notation allant de 1 à 5 étoiles. Il est également possible d’ajouter un commentaire afin de garder une trace de mes impressions, de rédiger un avis personnel ou simplement de noter ce qui m’a marqué pendant la lecture.
</p>

<p>
Explorez la bibliothèque pour découvrir les livres enregistrés, leurs notes et leurs commentaires.
</p>    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>