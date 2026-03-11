# 📚 GUIDE COMPLET DU PROJET - POUR DÉBUTANTS

**Projet : Ma Bibliothèque Personnelle en ligne**  
**Explication simple de chaque fichier**  
**Mars 2026**

---

## 🎯 C'EST QUOI CE PROJET ?

Imaginez un site web où vous pouvez :
- ✅ Créer un compte (comme sur Facebook)
- ✅ Vous connecter (avec pseudo et mot de passe)
- ✅ Chercher des livres sur Google
- ✅ Sauvegarder vos livres préférés
- ✅ Noter vos livres avec des étoiles (⭐⭐⭐⭐⭐)
- ✅ Écrire ce que vous en pensez
- ✅ Envoyer des messages via un formulaire de contact

**C'est comme Netflix, mais pour les livres !** 📚
lancer le projet avec [web](http://webdynamique.test/index.php)
---

## 📁 ORGANISATION DU PROJET

Votre projet ressemble à une maison 🏠 :

```
webdynamique/                    ← La maison (dossier principal)
│
├── 🚪 Pages d'entrée (ce que les gens voient)
│   ├── index.php                → Page d'accueil
│   ├── connexion.php            → Page de connexion
│   ├── inscription.php          → Page d'inscription
│   ├── contact.php              → Page de contact
│   ├── profil.php               → Votre profil
│   ├── bibliotheque.php         → Vos livres
│   ├── recherche.php            → Chercher des livres
│   └── deconnexion.php          → Se déconnecter
│
├── 🎨 Décoration (header et footer)
│   ├── header.php               → Menu du haut
│   └── footer.php               → Pied de page
│
├── ⚙️ config/ (la cuisine - où tout se prépare)
│   ├── config.php               → Recette pour se connecter à la base de données
│   └── config_mail.php          → Recette pour envoyer des emails
│
├── 🧠 controleur/ (le cerveau - la logique)
│   ├── connexion_controleur.php         → Vérifie si vous pouvez vous connecter
│   ├── inscription_controleur.php       → Crée votre compte
│   ├── contact_controler.php            → Envoie vos messages
│   ├── profil_controleur.php            → Affiche vos infos
│   ├── bibliotheque_controleur.php      → Gère vos livres
│   ├── recherche_controleur.php         → Cherche sur Google Books
│   └── gestionAuthentification.php      → Se souvient de vous
│
└── 🎨 asset/ (le placard - tout ce qui décore)
    ├── style.css                → Les couleurs et le style
    └── js/                      → Les animations
        ├── app.js
        ├── menu.js
        ├── compteur.js
        └── backToTop.js
```

---

## 📄 EXPLICATION DE CHAQUE FICHIER

### 🚪 LES PAGES (ce que vous voyez dans le navigateur)

#### 1. index.php - La porte d'entrée 🏠

**C'est quoi ?**
- La première page que vous voyez quand vous allez sur le site
- Comme la page d'accueil de Google ou Facebook

**Qu'est-ce qu'il fait ?**
- Affiche un message de bienvenue
- Montre le menu en haut
- Si vous êtes connecté : affiche "Bonjour Jean !"
- Si vous n'êtes pas connecté : affiche "Connectez-vous"

**Ce qu'il contient :**
```php
<?php
$pageTitle = "Accueil";                    // Le titre de la page
require_once __DIR__ . '/header.php';      // Charge le menu du haut
?>

<main>
    <h2>Bienvenue sur mon site web!</h2>
    <p>Découvrez notre bibliothèque...</p>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>  // Charge le pied de page
```

**En français :**
1. Dit que le titre est "Accueil"
2. Charge le menu (header)
3. Affiche un message de bienvenue
4. Charge le pied de page (footer)

---

#### 2. connexion.php - Se connecter 🔐

**C'est quoi ?**
- La page où vous entrez votre pseudo et mot de passe
- Comme quand vous vous connectez à Gmail

**Qu'est-ce qu'il fait ?**
- Affiche un formulaire (pseudo + mot de passe)
- Vérifie si vos identifiants sont corrects
- Si oui : vous êtes connecté !
- Si non : affiche "Mot de passe incorrect"

**Ce qu'il contient :**
```php
// 1. Charge le contrôleur (qui vérifie vos identifiants)
require_once __DIR__ . '/controleur/connexion_controleur.php';

// 2. Charge le menu
require_once __DIR__ . '/header.php';

// 3. Affiche le formulaire
<form method="post">
    <label>Pseudo :</label>
    <input type="text" name="pseudo">
    
    <label>Mot de passe :</label>
    <input type="password" name="motDePasse">
    
    <input type="checkbox" name="se_souvenir">
    Se souvenir de moi pendant 1 semaine
    
    <button>Connexion</button>
</form>
```

**En français :**
1. Affiche deux cases : pseudo et mot de passe
2. Affiche une case à cocher "Se souvenir de moi"
3. Quand vous cliquez "Connexion" :
   - Le contrôleur vérifie si c'est bon
   - Si oui : vous allez sur votre profil
   - Si non : message d'erreur

**La case "Se souvenir de moi" :**
- Si cochée : vous restez connecté 7 jours (même si vous fermez le navigateur)
- Si non cochée : vous êtes déconnecté quand vous fermez le navigateur

---

#### 3. inscription.php - Créer un compte 📝

**C'est quoi ?**
- La page pour créer votre compte
- Comme quand vous créez un compte Facebook

**Qu'est-ce qu'il fait ?**
- Affiche un formulaire avec vos informations
- Vérifie que tout est correct (email valide, mot de passe assez long)
- Crée votre compte dans la base de données
- Vous redirige vers la connexion

**Ce qu'il contient :**
```php
<form method="post">
    <input name="prenom" placeholder="Jean">
    <input name="nom" placeholder="Dupont">
    <input name="pseudo" placeholder="jeandupont">
    <input name="email" type="email" placeholder="jean@mail.com">
    <input name="motDePasse" type="password">
    <input name="motDePasseConfirme" type="password">
    <button>S'inscrire</button>
</form>
```

**Vérifications automatiques :**
- ✅ Prénom : au moins 2 lettres
- ✅ Email : doit être valide (avec @)
- ✅ Mot de passe : au moins 6 caractères
- ✅ Confirmation : les 2 mots de passe doivent être identiques
- ✅ Pseudo unique : personne d'autre ne doit l'avoir

**Exemple de message d'erreur :**
```
❌ Le mot de passe doit contenir au moins 6 caractères
❌ Les deux mots de passe ne correspondent pas
❌ Ce pseudo est déjà utilisé
```

---

#### 4. profil.php - Votre profil 👤

**C'est quoi ?**
- Votre page personnelle
- Comme votre profil Facebook ou Instagram

**Qu'est-ce qu'il fait ?**
- Affiche vos informations (prénom, nom, email)
- Montre combien de livres vous avez
- Affiche un bouton "Déconnexion"

**Ce qu'il contient :**
```php
<h2>Mon Profil</h2>

<p>Prénom : Jean</p>
<p>Nom : Dupont</p>
<p>Pseudo : jeandupont</p>
<p>Email : jean@mail.com</p>

<p>📚 Vous avez 12 livres dans votre bibliothèque</p>

<button>Voir ma bibliothèque</button>
<button>Déconnexion</button>
```

**Sécurité :**
Si vous n'êtes PAS connecté et que vous essayez d'aller sur profil.php :
→ Vous êtes redirigé vers connexion.php automatiquement

---

#### 5. bibliotheque.php - Vos livres 📚

**C'est quoi ?**
- La page où vous voyez tous vos livres
- Comme une bibliothèque personnelle, mais en ligne

**Qu'est-ce qu'il fait ?**
- Affiche tous vos livres en grille
- Montre la couverture de chaque livre (image)
- Affiche vos notes (⭐⭐⭐⭐⭐)
- Affiche vos commentaires
- Permet d'ajouter un livre manuellement
- Permet de supprimer un livre

**Ce qu'il contient :**

**Partie 1 : Ajouter un livre**
```php
<form method="post">
    <h3>Ajouter un livre</h3>
    <input name="titre" placeholder="Le Petit Prince">
    <input name="auteur" placeholder="Antoine de Saint-Exupéry">
    <textarea name="description"></textarea>
    <button>Ajouter</button>
</form>
```

**Partie 2 : Liste de vos livres**
```php
<div class="livres-grid">
    
    <!-- Livre 1 -->
    <div class="livre-card">
        <img src="couverture.jpg">
        <h4>Le Petit Prince</h4>
        <p>par Antoine de Saint-Exupéry</p>
        
        <!-- Vos notes -->
        <div>⭐⭐⭐⭐⭐ (5/5)</div>
        
        <!-- Votre commentaire -->
        <div class="commentaire">
            💭 Mon avis : Un chef-d'œuvre absolu !
        </div>
        
        <!-- Boutons -->
        <button>⭐ Noter / Commenter</button>
        <button>🗑️ Supprimer</button>
    </div>
    
    <!-- Livre 2, 3, 4... -->
    
</div>
```

**Fonctionnalités :**
1. **Noter un livre :**
   - Cliquez "⭐ Noter"
   - Choisissez de 0 à 5 étoiles
   - Écrivez votre avis
   - Cliquez "Enregistrer"
   - Vos notes s'affichent !

2. **Supprimer un livre :**
   - Cliquez "🗑️"
   - Confirmation : "Êtes-vous sûr ?"
   - Clic "Oui" → Livre supprimé

---

#### 6. recherche.php - Chercher des livres 🔍

**C'est quoi ?**
- La page pour chercher des livres sur Google Books
- Comme Google, mais juste pour les livres

**Qu'est-ce qu'il fait ?**
- Vous tapez un titre, auteur ou ISBN
- Il cherche sur Google Books (millions de livres)
- Affiche les résultats avec :
  - Image de couverture
  - Titre et auteur
  - Description
  - Éditeur
  - Date de publication
- Bouton pour ajouter à votre bibliothèque

**Ce qu'il contient :**

**Partie 1 : Barre de recherche**
```php
<form method="get">
    <input name="q" placeholder="Harry Potter, Victor Hugo, ISBN...">
    <button>🔍 Rechercher</button>
</form>
```

**Partie 2 : Résultats**
```php
<!-- Si vous avez tapé "Harry Potter" -->
<div class="resultats">
    
    <!-- Livre 1 -->
    <div class="livre-card">
        <img src="https://books.google.com/...">
        <h4>Harry Potter à l'école des sorciers</h4>
        <p>par J.K. Rowling</p>
        <p>Harry Potter, un jeune orphelin...</p>
        <p>📚 Gallimard Jeunesse</p>
        <p>📅 1998</p>
        <button>➕ Ajouter à ma bibliothèque</button>
    </div>
    
    <!-- Livre 2, 3, 4... jusqu'à 20 résultats -->
    
</div>
```

**Comment ça marche ?**
1. Vous tapez "Harry Potter"
2. Le site demande à Google Books : "Donne-moi les livres avec Harry Potter"
3. Google Books répond avec les résultats
4. Le site vous les affiche joliment
5. Vous cliquez "Ajouter" → Le livre va dans VOTRE bibliothèque

**Magie technique :**
- Le site utilise l'**API Google Books** (un robot qui cherche pour vous)
- Gratuit jusqu'à 1000 recherches par jour
- Pas besoin de créer de compte Google

---

#### 7. contact.php - Envoyer un message ✉️

**C'est quoi ?**
- Un formulaire pour envoyer un message
- Comme envoyer un email, mais depuis le site

**Qu'est-ce qu'il fait ?**
- Affiche un formulaire (nom, email, message)
- Vérifie que tout est rempli correctement
- Sauvegarde le message dans la base de données
- **Envoie un email à l'administrateur du site** 🆕
- Affiche "Message envoyé !"

**Ce qu'il contient :**
```php
<form method="post">
    <input name="prenom" placeholder="Jean">
    <input name="nom" placeholder="Dupont">
    <input name="pseudo" placeholder="jeandupont">
    <input name="email" type="email" placeholder="jean@mail.com">
    <textarea name="message" placeholder="Votre message..."></textarea>
    
    <!-- Compteur de caractères (automatique) -->
    <div>0 / 3000 caractères</div>
    
    <button>Envoyer</button>
</form>
```

**Vérifications :**
- ✅ Tous les champs remplis
- ✅ Email valide (avec @)
- ✅ Message entre 10 et 3000 caractères

**Après envoi :**
1. **Message sauvegardé** dans la base de données
2. **Email envoyé** à l'administrateur avec :
   - Vos informations (nom, email)
   - Votre message
   - Date et heure
3. **Confirmation** affichée : "✅ Message envoyé avec succès !"

**Compteur de caractères :**
En bas du message, vous voyez :
```
152 / 3000 caractères
```
→ Change en temps réel quand vous tapez !

---

#### 8. deconnexion.php - Se déconnecter 🚪

**C'est quoi ?**
- La page qui vous déconnecte
- Vous ne la voyez jamais, elle fait juste son travail

**Qu'est-ce qu'il fait ?**
1. Supprime votre session (vous oublie)
2. Supprime les cookies "Se souvenir de moi"
3. Supprime le token de la base de données
4. Vous redirige vers la page d'accueil

**Ce qu'il contient :**
```php
<?php
// 1. Charger la fonction de déconnexion
require_once __DIR__ . '/controleur/gestionAuthentification.php';

// 2. Vous déconnecter
deconnecter_utilisateur();

// 3. Vous renvoyer à l'accueil
header("Location: index.php");
exit();
?>
```

**En 3 secondes :**
```
Vous → Cliquez "Déconnexion"
     → deconnexion.php fait son travail
     → Vous êtes sur la page d'accueil, déconnecté
```

---

### 🎨 DÉCORATION (header et footer)

#### 9. header.php - Le menu du haut 🔝

**C'est quoi ?**
- Le menu que vous voyez en haut de TOUTES les pages
- Comme le menu de YouTube (Accueil, Tendances, Abonnements...)

**Qu'est-ce qu'il fait ?**
- Affiche le logo du site
- Affiche les liens du menu
- Change selon si vous êtes connecté ou pas
- Fonctionne sur mobile (menu hamburger ☰)

**Ce qu'il contient :**
```php
<!DOCTYPE html>
<html>
<head>
    <title>Mon Site</title>
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    
<header>
    <h1>📚 Mon Site Web</h1>
    
    <!-- Bouton hamburger (mobile seulement) -->
    <button id="menuToggle">☰</button>
    
    <nav>
        <ul>
            <li><a href="index.php">🏠 Accueil</a></li>
            <li><a href="contact.php">✉️ Contact</a></li>
            
            <?php if (vous êtes connecté): ?>
                <li><a href="recherche.php">🔍 Rechercher</a></li>
                <li><a href="bibliotheque.php">📚 Bibliothèque</a></li>
                <li><a href="profil.php">👤 Profil</a></li>
                <li><a href="deconnexion.php">🚪 Déconnexion</a></li>
            <?php else: ?>
                <li><a href="connexion.php">🔐 Connexion</a></li>
                <li><a href="inscription.php">📝 Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
```

**Menu intelligent :**

**Si vous ÊTES connecté :**
```
🏠 Accueil | ✉️ Contact | 🔍 Rechercher | 📚 Bibliothèque | 👤 Profil | 🚪 Déconnexion
```

**Si vous N'ÊTES PAS connecté :**
```
🏠 Accueil | ✉️ Contact | 🔐 Connexion | 📝 Inscription
```

**Sur mobile :**
- Menu caché derrière le bouton ☰
- Clic sur ☰ → Menu s'affiche
- Clic dehors → Menu se cache

---

#### 10. footer.php - Le pied de page 🔽

**C'est quoi ?**
- Ce qu'on voit tout en bas de TOUTES les pages
- Comme le bas de Google (Confidentialité, Conditions, À propos...)

**Qu'est-ce qu'il fait ?**
- Affiche le copyright (© 2026)
- Affiche des infos sur le site
- Charge tous les scripts JavaScript
- Affiche le bouton "↑ Retour en haut"

**Ce qu'il contient :**
```php
<footer>
    <p>&copy; 2026 - Mon site web. Tous droits réservés.</p>
    <p>Projet PHP/MySQL - Architecture MVC</p>
</footer>

<!-- Bouton retour en haut (apparaît quand vous scrollez) -->
<button id="backToTop">↑</button>

<!-- Scripts JavaScript -->
<script src="asset/js/app.js"></script>
<script src="asset/js/menu.js"></script>
<script src="asset/js/compteur.js"></script>
<script src="asset/js/backToTop.js"></script>

</body>
</html>
```

**Bouton "↑ Retour en haut" :**
- Invisible en haut de la page
- Apparaît quand vous descendez
- Clic → Remontée fluide vers le haut
- Position : coin bas droit

---

### ⚙️ CONFIG (la cuisine - où tout se prépare)

#### 11. config/config.php - Recette base de données 🗄️

**C'est quoi ?**
- Le fichier qui dit comment se connecter à la base de données
- Comme l'adresse et le code d'accès d'un coffre-fort

**Qu'est-ce qu'il fait ?**
- Stocke l'adresse de la base de données
- Stocke le nom d'utilisateur et mot de passe
- Active l'affichage des erreurs (pour vous aider à déboguer)

**Ce qu'il contient :**
```php
<?php

// Mode développement (affiche les erreurs)
define('DEV_MODE', true);

if (DEV_MODE) {
    ini_set('display_errors', '1');    // Montre les erreurs
    error_reporting(E_ALL);            // Montre TOUTES les erreurs
}

// Fonction qui donne les infos de connexion
function obtenirConfigBdd(): array {
    return [
        'serveur'     => 'localhost',      // Où est la base de données
        'bdd'         => 'bdd_projet_web', // Nom de la base de données
        'utilisateur' => 'root',           // Nom d'utilisateur
        'mdp'         => ''                // Mot de passe (vide sur Laragon)
    ];
}
```

**En français :**

**Mode développement :**
- Si vous faites une erreur → Vous voyez un message d'erreur détaillé
- Aide à trouver et corriger les bugs

**Connexion à la base de données :**
```
Serveur : localhost (votre ordinateur)
Base de données : bdd_projet_web (où sont stockés vos données)
Utilisateur : root (le compte admin)
Mot de passe : (rien, vide)
```

**Analogie :**
C'est comme dire à un facteur :
- Rue : localhost
- Immeuble : bdd_projet_web  
- Appartement : root
- Code : (pas de code)

---

#### 12. config/config_mail.php - Recette emails 📧

**C'est quoi ?**
- Le fichier qui dit où envoyer les emails
- **IMPORTANT : Votre adresse email est CACHÉE ici**

**Qu'est-ce qu'il fait ?**
- Stocke votre adresse email (celle qui recevra les messages)
- Configure le format des emails
- Configure le sujet des emails

**Ce qu'il contient :**
```php
<?php

// Fonction qui donne l'email de destination
function obtenirEmailDestination(): string {
    // ⚠️ VOTRE adresse email (celle qui reçoit les messages)
    return 'votre.email@gmail.com';
}

// Configuration des emails
function obtenirConfigEmail(): array {
    return [
        'sujet_prefixe' => '[Contact Site Web]',  // Début du sujet
        'reply_to'      => true,                  // Peut répondre directement
        'format'        => 'html'                 // Email en HTML (joli)
    ];
}
```

**Exemple d'email reçu :**
```
De : Formulaire de Contact
À : votre.email@gmail.com
Sujet : [Contact Site Web] Message de Jean Dupont
Date : 04/03/2026 22:45

┌─────────────────────────┐
│ 📧 Nouveau message      │
├─────────────────────────┤
│ Prénom : Jean           │
│ Nom : Dupont            │
│ Email : jean@test.com   │
├─────────────────────────┤
│ Message :               │
│ Bonjour, j'ai une       │
│ question...             │
└─────────────────────────┘
```

**Sécurité :**
Votre email est dans ce fichier, PAS dans le code HTML visible.
→ Les visiteurs ne peuvent PAS voir votre email !

---

### 🧠 CONTROLEUR (le cerveau - la logique)

**C'est quoi un contrôleur ?**

Imaginez un restaurant :
- **La page** (connexion.php) = Le serveur qui prend votre commande
- **Le contrôleur** = Le cuisinier qui prépare le plat
- **La base de données** = Le frigo avec les ingrédients

Le contrôleur fait le travail "intelligent" :
- Vérifier si vos identifiants sont corrects
- Créer votre compte
- Chercher des livres
- Sauvegarder vos notes
- Etc.

---

#### 13. controleur/connexion_controleur.php - Vérifier la connexion 🔐

**C'est quoi ?**
- Le fichier qui vérifie si vous pouvez vous connecter

**Qu'est-ce qu'il fait ?**

**Partie 1 : Vérifier le cookie "Se souvenir de moi"**
```
Quand vous arrivez sur le site :
1. Il cherche un cookie "remember_token"
2. Si trouvé :
   - Vérifie dans la base de données
   - Si valide → Vous connecte automatiquement
3. Si pas trouvé :
   - Continue normalement
```

**Partie 2 : Si vous cliquez "Connexion"**
```
1. Récupère votre pseudo
2. Récupère votre mot de passe
3. Vérifie dans la base de données :
   - Le pseudo existe ?
   - Le mot de passe correspond ?
4. Si OUI :
   - Vous connecte
   - Si "Se souvenir" coché :
     → Crée un cookie (7 jours)
   - Vous redirige vers profil.php
5. Si NON :
   - Affiche "Pseudo ou mot de passe incorrect"
```

**Ce qu'il contient (simplifié) :**
```php
// Si vous avez cliqué "Connexion"
if (formulaire soumis) {
    
    $pseudo = ce que vous avez tapé;
    $motDePasse = ce que vous avez tapé;
    
    // Chercher dans la base de données
    $utilisateur = chercher_dans_bdd($pseudo);
    
    // Vérifier le mot de passe
    if (mot de passe correct) {
        
        // Vous connecter
        connecter_utilisateur($utilisateur);
        
        // Si "Se souvenir de moi" coché
        if (case cochée) {
            // Créer un code secret unique
            $token = générer_code_secret();
            
            // Sauvegarder dans la BDD
            sauvegarder_token($token);
            
            // Créer un cookie (7 jours)
            créer_cookie($token);
        }
        
        // Aller sur votre profil
        rediriger_vers("profil.php");
        
    } else {
        afficher_erreur("Mot de passe incorrect");
    }
}
```

**Cookie "Se souvenir de moi" en détail :**

1. **Génération d'un code secret unique (token) :**
   ```
   Token = a7f3c2b8e9d1f4a6c5b8d9e2...  (64 caractères aléatoires)
   ```

2. **Sauvegarde dans la base de données :**
   ```
   Utilisateur : jeandupont
   Token : a7f3c2b8e9d1...
   Expire le : 11/03/2026 (dans 7 jours)
   ```

3. **Création du cookie dans votre navigateur :**
   ```
   Nom : remember_token
   Valeur : a7f3c2b8e9d1...
   Expire : 11/03/2026
   ```

4. **Prochaine visite :**
   ```
   Vous revenez demain :
   1. Le contrôleur voit le cookie
   2. Cherche le token dans la BDD
   3. Vérifie qu'il n'a pas expiré
   4. Vous connecte automatiquement !
   ```

---

#### 14. controleur/inscription_controleur.php - Créer un compte 📝

**C'est quoi ?**
- Le fichier qui crée votre compte

**Qu'est-ce qu'il fait ?**

**Étape par étape :**
```
1. Récupère vos informations :
   - Prénom : Jean
   - Nom : Dupont
   - Pseudo : jeandupont
   - Email : jean@mail.com
   - Mot de passe : ******

2. Vérifie TOUT :
   ✅ Prénom rempli ? (au moins 2 lettres)
   ✅ Email valide ? (avec @)
   ✅ Mot de passe assez long ? (6 caractères min)
   ✅ Les 2 mots de passe identiques ?
   ✅ Pseudo déjà pris ? (vérification dans la BDD)

3. Si TOUT est bon :
   - Crypte votre mot de passe (pour la sécurité)
   - Sauvegarde dans la base de données
   - Affiche "✅ Inscription réussie !"
   - Vous redirige vers connexion.php

4. Si une erreur :
   - Affiche le message d'erreur
   - Garde vos informations (pas besoin de tout retaper)
```

**Cryptage du mot de passe :**

**Vous tapez :** `motdepasse123`

**Sauvegardé dans la BDD :** `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`

**Pourquoi ?**
Si un hacker vole la base de données, il ne peut PAS voir votre mot de passe !
Il voit juste du charabia impossible à déchiffrer.

**Ce qu'il contient (simplifié) :**
```php
if (formulaire soumis) {
    
    // 1. Récupérer les infos
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $motDePasse = $_POST['motDePasse'];
    
    // 2. Vérifications
    if (prénom vide) {
        erreur("Le prénom est obligatoire");
    }
    
    if (email pas valide) {
        erreur("Email invalide");
    }
    
    if (mot de passe trop court) {
        erreur("6 caractères minimum");
    }
    
    if (pseudo déjà utilisé) {
        erreur("Ce pseudo existe déjà");
    }
    
    // 3. Si pas d'erreur
    if (tout est bon) {
        
        // Crypter le mot de passe
        $motDePasseCrypte = crypter($motDePasse);
        
        // Sauvegarder dans la BDD
        sauvegarder_utilisateur(
            $prenom,
            $nom,
            $pseudo,
            $email,
            $motDePasseCrypte
        );
        
        // Message de succès
        afficher("✅ Inscription réussie !");
    }
}
```

---

#### 15. controleur/profil_controleur.php - Afficher le profil 👤

**C'est quoi ?**
- Le fichier qui récupère vos informations pour les afficher

**Qu'est-ce qu'il fait ?**
```
1. Vérifie que vous êtes connecté
   Si NON → Redirige vers connexion.php
   
2. Récupère votre ID de session
   
3. Cherche vos infos dans la base de données :
   - Prénom
   - Nom
   - Pseudo
   - Email
   - Nombre de livres
   
4. Envoie les infos à profil.php pour affichage
```

**Ce qu'il contient (simplifié) :**
```php
// 1. Vérifier connexion
if (pas connecté) {
    rediriger_vers("connexion.php");
}

// 2. Récupérer votre ID
$monId = utilisateur_connecte();

// 3. Chercher dans la BDD
$mesInfos = chercher_dans_bdd(
    "SELECT prenom, nom, pseudo, email 
     FROM utilisateurs 
     WHERE id = $monId"
);

// 4. Compter vos livres
$nbLivres = compter_livres($monId);

// Résultat :
// $mesInfos = [
//     'prenom' => 'Jean',
//     'nom' => 'Dupont',
//     'pseudo' => 'jeandupont',
//     'email' => 'jean@mail.com'
// ]
// $nbLivres = 12
```

**Puis profil.php affiche :**
```
Mon Profil

Prénom : Jean
Nom : Dupont
Pseudo : jeandupont
Email : jean@mail.com

📚 Vous avez 12 livres dans votre bibliothèque

[Voir ma bibliothèque] [Déconnexion]
```

---

#### 16. controleur/bibliotheque_controleur.php - Gérer les livres 📚

**C'est quoi ?**
- Le fichier qui gère tout ce qui concerne vos livres

**Qu'est-ce qu'il fait ?**

**Fonction 1 : Ajouter un livre**
```
Si vous cliquez "Ajouter le livre" :
1. Récupère titre + auteur + description
2. Vérifie que tout est rempli
3. Sauvegarde dans la BDD
4. Affiche "✅ Livre ajouté !"
```

**Fonction 2 : Noter un livre**
```
Si vous cliquez "Enregistrer" (note + commentaire) :
1. Récupère la note (0 à 5)
2. Récupère le commentaire
3. Met à jour dans la BDD
4. Affiche "✅ Note enregistrée !"
```

**Fonction 3 : Supprimer un livre**
```
Si vous cliquez "🗑️" :
1. Demande confirmation
2. Supprime de la BDD
3. Affiche "✅ Livre supprimé !"
```

**Fonction 4 : Afficher tous vos livres**
```
1. Cherche dans la BDD tous VOS livres
2. Les trie par date (plus récent d'abord)
3. Envoie la liste à bibliotheque.php
```

**Ce qu'il contient (simplifié) :**
```php
// AJOUTER UN LIVRE
if (formulaire "Ajouter" soumis) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    
    if (titre rempli ET auteur rempli) {
        sauvegarder_livre($titre, $auteur, $monId);
        afficher("✅ Livre ajouté !");
    }
}

// NOTER UN LIVRE
if (formulaire "Noter" soumis) {
    $livreId = $_POST['livre_id'];
    $note = $_POST['note'];         // 0 à 5
    $commentaire = $_POST['commentaire'];
    
    mettre_a_jour_note($livreId, $note, $commentaire);
    afficher("✅ Note enregistrée !");
}

// SUPPRIMER UN LIVRE
if (clic sur "Supprimer") {
    $livreId = $_POST['supprimer_id'];
    
    supprimer_livre($livreId, $monId);
    afficher("✅ Livre supprimé !");
}

// RÉCUPÉRER TOUS LES LIVRES
$mesLivres = chercher_dans_bdd(
    "SELECT * FROM livres 
     WHERE utilisateur_id = $monId 
     ORDER BY date_ajout DESC"
);

// Résultat :
// $mesLivres = [
//     [
//         'id' => 1,
//         'titre' => 'Le Petit Prince',
//         'auteur' => 'Saint-Exupéry',
//         'note' => 5,
//         'commentaire' => 'Chef-d\'œuvre !'
//     ],
//     [
//         'id' => 2,
//         'titre' => 'Harry Potter',
//         ...
//     ]
// ]
```

---

#### 17. controleur/recherche_controleur.php - Chercher sur Google Books 🔍

**C'est quoi ?**
- Le fichier qui cherche des livres sur Google Books

**Qu'est-ce qu'il fait ?**

**Fonction 1 : Chercher des livres**
```
Quand vous tapez "Harry Potter" et cliquez "Rechercher" :

1. Prépare l'adresse de Google Books :
   https://www.googleapis.com/books/v1/volumes?q=Harry+Potter

2. Envoie la demande à Google Books
   (comme si vous alliez sur leur site)

3. Google Books répond avec une liste de livres :
   {
     "items": [
       {
         "volumeInfo": {
           "title": "Harry Potter à l'école des sorciers",
           "authors": ["J.K. Rowling"],
           "description": "Harry Potter, un jeune orphelin...",
           "imageLinks": {
             "thumbnail": "http://books.google.com/image.jpg"
           },
           "publisher": "Gallimard",
           "publishedDate": "1998"
         }
       },
       ... (jusqu'à 20 livres)
     ]
   }

4. Transforme cette liste en format facile à afficher

5. Envoie à recherche.php
```

**Fonction 2 : Ajouter un livre trouvé**
```
Quand vous cliquez "Ajouter à ma bibliothèque" :

1. Récupère toutes les infos du livre :
   - Titre
   - Auteur
   - Description
   - Image
   - Éditeur
   - Date

2. Vérifie si vous n'avez pas déjà ce livre

3. Sauvegarde dans VOTRE bibliothèque

4. Affiche "✅ Livre ajouté !"
```

**Ce qu'il contient (simplifié) :**
```php
// RECHERCHE
if (vous avez tapé quelque chose) {
    
    $recherche = $_GET['q'];  // Ex: "Harry Potter"
    
    // 1. Préparer l'URL
    $url = "https://www.googleapis.com/books/v1/volumes?q=" 
         . $recherche 
         . "&maxResults=20";
    
    // 2. Demander à Google Books
    $reponse = appeler_google_books($url);
    
    // 3. Transformer en liste
    $livres = [];
    foreach ($reponse['items'] as $item) {
        $livres[] = [
            'titre' => $item['volumeInfo']['title'],
            'auteur' => $item['volumeInfo']['authors'][0],
            'image' => $item['volumeInfo']['imageLinks']['thumbnail'],
            'description' => $item['volumeInfo']['description'],
            'editeur' => $item['volumeInfo']['publisher'],
            'date' => $item['volumeInfo']['publishedDate']
        ];
    }
    
    // 4. Envoyer à la page
    // $livres contient 20 livres prêts à afficher
}

// AJOUTER UN LIVRE TROUVÉ
if (clic sur "Ajouter") {
    
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $description = $_POST['description'];
    $image = $_POST['image_url'];
    $editeur = $_POST['editeur'];
    
    // Vérifier doublon
    if (livre déjà dans votre bibliothèque) {
        afficher("❌ Vous avez déjà ce livre");
    } else {
        sauvegarder_livre(
            $titre, 
            $auteur, 
            $description,
            $image,
            $editeur,
            $monId
        );
        afficher("✅ Livre ajouté !");
    }
}
```

**Explication de l'API :**

**API = Application Programming Interface**

En français : "Interface pour que les programmes se parlent"

**Analogie :**
- **Vous** = Votre site web
- **Restaurant** = Google Books
- **Serveur** = L'API

Conversation :
```
Vous : "Je voudrais voir le menu de livres sur Harry Potter"
Serveur API : "Voici 20 livres Harry Potter avec toutes les infos"
Vous : "Merci, je vais les afficher joliment à mes visiteurs"
```

**Gratuit :**
- 1000 recherches par jour
- Pas besoin de clé API
- Millions de livres disponibles

---

#### 18. controleur/contact_controler.php - Gérer le formulaire de contact ✉️

**C'est quoi ?**
- Le fichier qui traite les messages de contact

**Qu'est-ce qu'il fait ?**

**Étape par étape :**
```
1. Vous remplissez le formulaire de contact

2. Le contrôleur vérifie TOUT :
   ✅ Prénom : entre 2 et 255 caractères
   ✅ Nom : entre 2 et 255 caractères
   ✅ Pseudo : entre 2 et 50 caractères
   ✅ Email : valide (avec @)
   ✅ Message : entre 10 et 3000 caractères

3. Si TOUT est bon :
   
   a) Sauvegarde dans la base de données
      → Vous gardez une trace de tous les messages
   
   b) Envoie un email à l'administrateur
      Format HTML joli avec :
      - Vos informations
      - Votre message
      - Date et heure
   
   c) Affiche "✅ Message envoyé avec succès !"

4. Si une erreur :
   - Affiche le problème
   - Garde vos informations (pas besoin de tout retaper)
```

**Ce qu'il contient (simplifié) :**
```php
if (formulaire soumis) {
    
    // 1. Récupérer les infos
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // 2. Vérifications
    if (prenom trop court) {
        erreur("Prénom : 2 caractères minimum");
    }
    
    if (email pas valide) {
        erreur("Email invalide");
    }
    
    if (message trop court) {
        erreur("Message : 10 caractères minimum");
    }
    
    // 3. Si tout est bon
    if (pas d'erreur) {
        
        // a) Sauvegarder dans la BDD
        sauvegarder_message(
            $prenom,
            $nom,
            $pseudo,
            $email,
            $message
        );
        
        // b) Envoyer l'email
        $emailAdmin = obtenirEmailDestination();  // De config_mail.php
        
        $sujet = "[Contact Site Web] Message de $prenom $nom";
        
        $corpsEmail = "
            📧 Nouveau message
            
            Prénom : $prenom
            Nom : $nom
            Pseudo : $pseudo
            Email : $email
            
            Message :
            $message
            
            Reçu le " . date('d/m/Y à H:i:s') . "
        ";
        
        envoyer_email($emailAdmin, $sujet, $corpsEmail);
        
        // c) Confirmation
        afficher("✅ Message envoyé avec succès !");
    }
}
```

**Email HTML envoyé :**

L'email que vous recevez est joli (format HTML) :

```html
┌──────────────────────────────────┐
│  📧 Nouveau message de contact   │
├──────────────────────────────────┤
│  Prénom : Jean                   │
│  Nom : Dupont                    │
│  Pseudo : jeandupont             │
│  Email : jean@test.com           │
├──────────────────────────────────┤
│  Message :                       │
│                                  │
│  Bonjour, j'ai une question      │
│  sur le fonctionnement du site.  │
│  Pouvez-vous m'aider ?           │
├──────────────────────────────────┤
│  Message reçu le 04/03/2026      │
│  à 22:45:30                      │
└──────────────────────────────────┘
```

**Vous pouvez répondre directement** en cliquant "Répondre" dans votre boîte mail !

---

#### 19. controleur/gestionAuthentification.php - Se souvenir de vous 🧠

**C'est quoi ?**
- Le fichier qui gère votre connexion (sessions et cookies)

**Qu'est-ce qu'il fait ?**

**Fonction 1 : Vous connecter**
```php
function connecter_utilisateur($votreId) {
    // Créer une session
    $_SESSION['utilisateurId'] = $votreId;
    
    // Régénérer l'ID de session (sécurité)
    session_regenerate_id(true);
}
```

**En français :**
- Crée un "post-it virtuel" avec votre ID
- Le serveur se souvient de vous pendant votre visite

**Fonction 2 : Vérifier si vous êtes connecté**
```php
function est_connecte() {
    return isset($_SESSION['utilisateurId']);
}
```

**En français :**
- Regarde si le "post-it" existe
- Si oui → Vous êtes connecté
- Si non → Vous n'êtes pas connecté

**Fonction 3 : Récupérer votre ID**
```php
function utilisateur_id() {
    return $_SESSION['utilisateurId'] ?? null;
}
```

**En français :**
- Lit le numéro sur le "post-it"
- Utilisé partout pour savoir qui vous êtes

**Fonction 4 : Vous déconnecter**
```php
function deconnecter_utilisateur() {
    
    // 1. Supprimer le cookie "Se souvenir de moi"
    if (cookie existe) {
        // Supprimer dans la BDD
        supprimer_token_bdd();
        
        // Supprimer dans le navigateur
        supprimer_cookie();
    }
    
    // 2. Détruire la session
    session_unset();      // Vide le "post-it"
    session_destroy();    // Jette le "post-it"
    
    // 3. Recréer une session vide
    session_start();
}
```

**En français :**
1. Supprime le token de la BDD
2. Supprime le cookie du navigateur
3. Jette le "post-it" de session
4. Vous êtes déconnecté

**Sessions vs Cookies :**

**Session (temporaire) :**
```
Durée : Jusqu'à fermeture du navigateur
Stockage : Sur le serveur
Exemple : Vous visitez le site, fermez le navigateur → Déconnecté
```

**Cookie "Se souvenir de moi" (permanent) :**
```
Durée : 7 jours
Stockage : Dans le navigateur + BDD
Exemple : Vous visitez le site, fermez, revenez demain → Toujours connecté
```

---

### 🎨 ASSETS (le placard - décoration et animations)

#### 20. asset/style.css - Les couleurs et le style 🎨

**C'est quoi ?**
- Le fichier qui dit comment les éléments doivent être affichés
- Les couleurs, tailles, positions, etc.

**Qu'est-ce qu'il fait ?**
- Définit les couleurs du site
- Définit la taille des textes
- Positionne les éléments
- Rend le site beau et utilisable

**Exemples de styles :**

**1. Couleurs principales :**
```css
/* Menu du haut */
nav {
    background-color: #7f7e7e;  /* Gris */
}

/* Titres */
h2 {
    color: #e70909;  /* Rouge */
}

/* Bouton "Envoyer" */
#sub {
    background-color: #4CAF50;  /* Vert */
    color: white;
}
```

**2. Responsive (mobile) :**
```css
/* Sur grand écran : menu horizontal */
nav ul {
    display: flex;  /* Les liens côte à côte */
}

/* Sur mobile : menu vertical */
@media (max-width: 768px) {
    nav ul {
        display: block;  /* Les liens empilés */
    }
}
```

**3. Formulaires :**
```css
/* Centrer les formulaires */
form {
    width: 75%;
    margin: 0 auto;  /* Centré */
    background-color: #ccc;  /* Fond gris clair */
    padding: 30px;
    border-radius: 5px;  /* Coins arrondis */
}

/* Champs avec erreur */
.erreur-champ {
    border: 2px solid red;  /* Bordure rouge */
    background-color: #ffe6e6;  /* Fond rose */
}
```

**4. Cartes de livres :**
```css
.livre-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);  /* Ombre */
}

/* Au survol : carte monte */
.livre-card:hover {
    transform: translateY(-5px);  /* Monte de 5 pixels */
}
```

**5. Bouton retour en haut :**
```css
.back-to-top {
    position: fixed;  /* Toujours au même endroit */
    bottom: 30px;
    right: 30px;
    background-color: #4CAF50;  /* Vert */
    color: white;
    border-radius: 50%;  /* Rond */
    width: 50px;
    height: 50px;
    
    /* Caché par défaut */
    opacity: 0;
    visibility: hidden;
}

/* Visible quand vous scrollez */
.back-to-top.visible {
    opacity: 1;
    visibility: visible;
}
```

**En français :**
Le CSS = Les instructions pour le navigateur sur comment afficher les choses

**Analogie :**
- **HTML** = Les meubles d'une maison
- **CSS** = La peinture, la décoration, l'agencement

---

#### 21. asset/js/app.js - Script principal 🎬

**C'est quoi ?**
- Le fichier JavaScript principal
- S'exécute quand la page se charge

**Qu'est-ce qu'il fait ?**
```javascript
// Attend que TOUT soit chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // Affiche un message dans la console du navigateur
    console.log('✅ Application chargée');
    
    // Message stylisé
    console.log('%c📚 Bienvenue sur Mon Site Web', 
                'color: #4CAF50; font-size: 16px; font-weight: bold;');
});
```

**En français :**
Quand vous ouvrez une page :
1. Le navigateur charge le HTML
2. Le navigateur charge le CSS
3. Le navigateur charge les JS
4. app.js dit "Je suis prêt !"
5. Message dans la console (F12 pour voir)

**Console du navigateur (F12) :**
```
✅ Application chargée
📚 Bienvenue sur Mon Site Web
```

---

#### 22. asset/js/menu.js - Menu responsive ☰

**C'est quoi ?**
- Le fichier qui gère le menu hamburger sur mobile

**Qu'est-ce qu'il fait ?**

**Sur mobile :**
```
1. Menu caché par défaut
2. Bouton ☰ visible
3. Clic sur ☰ → Menu s'affiche
4. Clic dehors → Menu se cache
```

**Ce qu'il contient :**
```javascript
// Attend que tout soit chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // Récupérer les éléments
    const bouton = document.getElementById('menuToggle');
    const menu = document.getElementById('mainNav');
    
    // Quand on clique sur le bouton ☰
    bouton.addEventListener('click', function() {
        
        // Afficher/cacher le menu
        menu.classList.toggle('active');
        
        // Changer l'icône
        if (menu.classList.contains('active')) {
            bouton.textContent = '✕';  // Croix
        } else {
            bouton.textContent = '☰';  // Hamburger
        }
    });
    
    // Clic en dehors du menu → Fermer
    document.addEventListener('click', function(e) {
        if (pas sur le bouton ET pas sur le menu) {
            menu.classList.remove('active');
            bouton.textContent = '☰';
        }
    });
});
```

**En français :**

**État initial (mobile) :**
```
[☰]    Mon Site
```

**Après clic sur ☰ :**
```
[✕]    Mon Site

       🏠 Accueil
       ✉️ Contact
       🔍 Rechercher
       📚 Bibliothèque
       👤 Profil
       🚪 Déconnexion
```

**Après clic dehors :**
```
[☰]    Mon Site
```

---

#### 23. asset/js/compteur.js - Compteur de caractères 🔢

**C'est quoi ?**
- Le fichier qui compte vos caractères dans les champs message

**Qu'est-ce qu'il fait ?**

**Dans le formulaire de contact :**
```
┌────────────────────────────────┐
│ Message :                      │
│                                │
│ [Bonjour, j'ai une question_]  │
│                                │
│ 28 / 3000 caractères           │ ← Compteur
└────────────────────────────────┘
```

**Ce qu'il contient :**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    
    // Trouver tous les champs textarea
    const textareas = document.querySelectorAll('textarea');
    
    textareas.forEach(function(textarea) {
        
        // Créer un compteur
        const compteur = document.createElement('div');
        compteur.style.textAlign = 'right';
        compteur.style.fontSize = '0.9em';
        compteur.style.color = '#666';
        
        // L'ajouter après le textarea
        textarea.parentNode.insertBefore(compteur, textarea.nextSibling);
        
        // Fonction de mise à jour
        function mettreAJour() {
            const longueur = textarea.value.length;
            const max = 3000;
            
            compteur.textContent = longueur + ' / ' + max + ' caractères';
            
            // Changer la couleur selon la longueur
            if (longueur > max * 0.9) {
                compteur.style.color = '#d00';  // Rouge (> 90%)
            } else if (longueur > max * 0.7) {
                compteur.style.color = '#f90';  // Orange (> 70%)
            } else {
                compteur.style.color = '#666';  // Gris (normal)
            }
        }
        
        // Mettre à jour quand vous tapez
        textarea.addEventListener('input', mettreAJour);
        
        // Initialiser
        mettreAJour();
    });
});
```

**En français :**

**Vous tapez :**
```
"Bonjour"        → 7 / 3000 caractères (gris)
```

**Vous continuez :**
```
"Bonjour, j'ai une question sur votre site..."
→ 50 / 3000 caractères (gris)
```

**Vous approchez de la limite :**
```
"Bonjour, j'ai une question... [2500 caractères]"
→ 2500 / 3000 caractères (orange)
```

**Presque au max :**
```
"Bonjour, j'ai une question... [2800 caractères]"
→ 2800 / 3000 caractères (rouge)
```

---

#### 24. asset/js/backToTop.js - Bouton retour haut ⬆️

**C'est quoi ?**
- Le fichier qui gère le bouton "↑ Retour en haut"

**Qu'est-ce qu'il fait ?**

**Comportement :**
```
1. En haut de page : Bouton invisible
2. Vous descendez (scroll) : Bouton apparaît
3. Clic sur le bouton : Remontée fluide en haut
4. En haut : Bouton disparaît
```

**Ce qu'il contient :**
```javascript
document.addEventListener('DOMContentLoaded', function() {
    
    const bouton = document.getElementById('backToTop');
    
    // Quand vous scrollez
    window.addEventListener('scroll', function() {
        
        // Si vous êtes à plus de 300px du haut
        if (window.pageYOffset > 300) {
            bouton.classList.add('visible');  // Afficher
        } else {
            bouton.classList.remove('visible');  // Cacher
        }
    });
    
    // Quand vous cliquez sur le bouton
    bouton.addEventListener('click', function() {
        
        // Remonter en douceur vers le haut
        window.scrollTo({
            top: 0,
            behavior: 'smooth'  // Animation fluide
        });
    });
});
```

**En français :**

**Position 1 (en haut) :**
```
┌────────────────┐
│ Mon Site       │  ← Menu
├────────────────┤
│                │
│ Contenu ici    │
│                │
```
Bouton invisible

**Position 2 (vous scrollez) :**
```
│                │
│ Contenu...     │
│                │
│ Contenu...     │
│                │  
│ Contenu...     │    [↑] ← Bouton apparaît !
│                │
```

**Position 3 (vous cliquez ↑) :**
```
Animation fluide qui remonte
↑
↑
↑
```

**Position 4 (retour en haut) :**
```
┌────────────────┐
│ Mon Site       │  ← Menu
├────────────────┤
│                │
│ Contenu ici    │
│                │
```
Bouton invisible à nouveau

---

## 🗄️ BASE DE DONNÉES

**C'est quoi une base de données ?**

Imaginez un **classeur géant** avec des **tiroirs étiquetés**.

Chaque tiroir = une **table**  
Chaque fiche dans le tiroir = une **ligne**  
Chaque info sur la fiche = une **colonne**

**Exemple concret :**

**Tiroir "Utilisateurs" (table t_utilisateur_uti) :**

```
┌────────────────────────────────────────────────────┐
│ Fiche n°1 (ligne 1)                                │
│ ├─ ID : 1                                          │
│ ├─ Prénom : Jean                                   │
│ ├─ Nom : Dupont                                    │
│ ├─ Pseudo : jeandupont                             │
│ ├─ Email : jean@mail.com                           │
│ ├─ Mot de passe : $2y$10$92IXUNpkjO... (crypté)   │
│ └─ Date d'inscription : 01/03/2026                 │
├────────────────────────────────────────────────────┤
│ Fiche n°2 (ligne 2)                                │
│ ├─ ID : 2                                          │
│ ├─ Prénom : Marie                                  │
│ ├─ Nom : Martin                                    │
│ └─ ...                                             │
└────────────────────────────────────────────────────┘
```

**Tiroir "Livres" (table t_livre_liv) :**

```
┌────────────────────────────────────────────────────┐
│ Fiche n°1                                          │
│ ├─ ID : 1                                          │
│ ├─ Titre : Le Petit Prince                         │
│ ├─ Auteur : Antoine de Saint-Exupéry               │
│ ├─ Note : 5 ⭐⭐⭐⭐⭐                                │
│ ├─ Commentaire : Chef-d'œuvre !                    │
│ └─ Propriétaire : Jean (ID 1)                      │
├────────────────────────────────────────────────────┤
│ Fiche n°2                                          │
│ ├─ ID : 2                                          │
│ ├─ Titre : Harry Potter                            │
│ └─ ...                                             │
└────────────────────────────────────────────────────┘
```

**Relation entre les tiroirs :**

Jean (utilisateur ID 1) possède :
- Le Petit Prince (livre ID 1)
- Harry Potter (livre ID 2)
- 1984 (livre ID 3)

Marie (utilisateur ID 2) possède :
- Le Petit Prince (livre ID 4, **sa propre copie**)
- Fondation (livre ID 5)

**Chacun a ses propres livres et ses propres notes !**

---

## 🔐 SÉCURITÉ

### Comment vos données sont protégées ?

**1. Mot de passe crypté**

**Vous tapez :** `motdepasse123`

**Sauvegardé :** `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`

**Impossible à déchiffrer !**  
Même si un hacker vole la base de données, il ne peut PAS voir votre mot de passe.

**2. Protection contre le vol de données (SQL Injection)**

**Attaque (ce que fait un hacker) :**
```
Pseudo : admin' OR '1'='1
```

**Protection (ce que fait le site) :**
```php
// ❌ DANGEREUX (ancien style)
$query = "SELECT * FROM users WHERE pseudo = '$pseudo'";

// ✅ SÉCURISÉ (requêtes préparées)
$stmt = $pdo->prepare("SELECT * FROM users WHERE pseudo = ?");
$stmt->execute([$pseudo]);
```

**Résultat :** L'attaque ne fonctionne pas !

**3. Protection contre le vol de cookies (XSS)**

**Attaque :**
```html
<script>voler_cookie()</script>
```

**Protection :**
```php
// Échappement automatique
echo htmlspecialchars($texte);

// Cookie HttpOnly (inaccessible via JavaScript)
setcookie('remember_token', $token, ..., true);
```

**4. Email caché**

**❌ MAL :**
```html
<form action="send.php?email=admin@site.com">
```
→ Email visible dans le code source !

**✅ BIEN :**
```php
// config_mail.php (serveur, invisible)
function obtenirEmailDestination(): string {
    return 'admin@site.com';
}
```
→ Email jamais envoyé au navigateur !

**5. Cookies sécurisés**

```php
setcookie(
    'remember_token',
    $token,
    time() + (7 * 24 * 60 * 60),  // 7 jours
    '/',
    '',
    false,  // true en HTTPS (production)
    true    // HttpOnly (protection XSS)
);
```

**Sécurité :**
- ✅ Token unique impossible à deviner
- ✅ HttpOnly : JavaScript ne peut pas le lire
- ✅ Expiration : 7 jours maximum
- ✅ Supprimé à la déconnexion

---

## 🎯 RÉCAPITULATIF FINAL

### Votre projet c'est :

**Pages utilisateur (8) :**
1. ✅ Page d'accueil
2. ✅ Connexion (avec "Se souvenir de moi")
3. ✅ Inscription
4. ✅ Profil
5. ✅ Bibliothèque (noter, commenter, supprimer)
6. ✅ Recherche API Google Books
7. ✅ Contact (avec envoi d'email)
8. ✅ Déconnexion

**Contrôleurs (7) :**
1. ✅ Gestion connexion + cookies
2. ✅ Gestion inscription
3. ✅ Gestion profil
4. ✅ Gestion bibliothèque
5. ✅ Gestion recherche API
6. ✅ Gestion contact + email
7. ✅ Gestion authentification

**Fichiers config (2) :**
1. ✅ Configuration base de données
2. ✅ Configuration email (caché)

**JavaScript (4) :**
1. ✅ Script principal
2. ✅ Menu responsive
3. ✅ Compteur caractères
4. ✅ Bouton retour haut

**CSS (1) :**
1. ✅ Style complet du site

**Base de données (3 tables) :**
1. ✅ Utilisateurs (avec cookies)
2. ✅ Livres (avec notes)
3. ✅ Messages contact

---

## 🎉 FÉLICITATIONS !

**Vous avez créé un site web complet avec :**

✅ **Inscription/Connexion sécurisée**  
✅ **Cookies "Se souvenir de moi"** (7 jours)  
✅ **Recherche de livres** (API Google Books)  
✅ **Bibliothèque personnelle**  
✅ **Notes en étoiles** (0-5)  
✅ **Commentaires personnels**  
✅ **Formulaire de contact** (avec email)  
✅ **Menu responsive** (mobile)  
✅ **Design moderne**  
✅ **Sécurité maximale**  

**Total : 24 fichiers | ~3400 lignes de code | 15 fonctionnalités**

---


*Ce projet démontre la maîtrise complète du développement web : PHP, MySQL, JavaScript, CSS, API REST, sécurité, et architecture MVC.*

