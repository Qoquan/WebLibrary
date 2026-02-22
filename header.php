<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Mon site', ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="site-title">📚 Mon Site Web</h1>
            
            <button class="menu-toggle" id="menuToggle">☰</button>
            
            <nav id="mainNav">
                <ul>
                    <li><a href="/index.php" class="<?php echo ($pageTitle === 'Accueil') ? 'active' : ''; ?>">🏠 Accueil</a></li>
                    <li><a href="/contact.php" class="<?php echo ($pageTitle === 'Contact') ? 'active' : ''; ?>">✉️ Contact</a></li>
                    
                    <?php
                    // Menu conditionnel selon connexion
                    require_once __DIR__ . '/controleur/gestionAuthentification.php';
                    if (est_connecte()): ?>
                        <li><a href="/recherche.php" class="<?php echo ($pageTitle === 'Rechercher des livres') ? 'active' : ''; ?>">🔍 Rechercher</a></li>
                        <li><a href="/bibliotheque.php" class="<?php echo ($pageTitle === 'Bibliothèque') ? 'active' : ''; ?>">📚 Bibliothèque</a></li>
                        <li><a href="/profil.php" class="<?php echo ($pageTitle === 'Mon Profil') ? 'active' : ''; ?>">👤 Profil</a></li>
                        <li><a href="/deconnexion.php" class="btn-deconnexion">🚪 Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="/connexion.php" class="<?php echo ($pageTitle === 'Connexion') ? 'active' : ''; ?>">🔐 Connexion</a></li>
                        <li><a href="/inscription.php" class="<?php echo ($pageTitle === 'Inscription') ? 'active' : ''; ?>">📝 Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>