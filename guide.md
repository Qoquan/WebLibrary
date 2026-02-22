# 📚 GUIDE D'INSTALLATION COMPLET



### ✅ JavaScript (créer dossier `asset/js/`) :

7. **app.js** → `asset/js/app.js`

8. **menu.js** → `asset/js/menu.js`

9. **compteur.js** → `asset/js/compteur.js`

### ✅ CSS amélioré (OPTIONNEL) :

10. **style_ameliore.css** → Peut remplacer `asset/style.css`
    - OU copier les parties qui vous intéressent

---

## 🗄️ ÉTAPE 1 : CRÉER LES TABLES (5 minutes)

### Ouvrez phpMyAdmin

1. Allez sur : `http://localhost/phpmyadmin`
2. Cliquez sur `bdd_projet_web` à gauche
3. Cliquez sur l'onglet **SQL**
4. Copiez-collez ce code :

```sql
USE bdd_projet_web;

-- Table des contacts
CREATE TABLE IF NOT EXISTS t_contact_con (
    con_id INT AUTO_INCREMENT PRIMARY KEY,
    con_prenom VARCHAR(255) NOT NULL,
    con_nom VARCHAR(255) NOT NULL,
    con_pseudo VARCHAR(50) NOT NULL,
    con_email VARCHAR(255) NOT NULL,
    con_message TEXT NOT NULL,
    con_date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des livres
CREATE TABLE IF NOT EXISTS t_livre_liv (
    liv_id INT AUTO_INCREMENT PRIMARY KEY,
    liv_titre VARCHAR(500) NOT NULL,
    liv_auteur VARCHAR(255) NOT NULL,
    liv_description TEXT,
    liv_utilisateur_id INT NOT NULL,
    liv_date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (liv_utilisateur_id) 
        REFERENCES t_utilisateur_uti(uti_id) 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

5. Cliquez sur **Exécuter**

### Vérification :

Vous devriez voir 3 tables :
- ✅ t_utilisateur_uti
- ✅ t_contact_con (NOUVEAU)
- ✅ t_livre_liv (NOUVEAU)

---

## 📁 ÉTAPE 2 : INSTALLER LES FICHIERS (10 minutes)

### Structure finale :

```
C:\laragon\www\ExamenWeb\
├── index.php
├── contact.php
├── connexion.php
├── inscription.php
├── profil.php
├── bibliotheque.php         
├── deconnexion.php           
├── header.php                
├── footer.php                
├── asset/
│   ├── style.css             
│   └── js/                   
│       ├── app.js            
│       ├── menu.js           
│       └── compteur.js       
├── config/
│   └── config.php
└── controleur/
    ├── contact_controler.php         
    ├── bibliotheque_controleur.php   
    ├── connexion_controleur.php
    ├── inscription_controleur.php
    ├── profil_controleur.php
    └── gestionAuthentification.php
```


#### A. Créer le dossier JavaScript
```
C:\laragon\www\ExamenWeb\asset\js\
```

#### B. 

1. **header.php** :
   - Sauvegardez l'ancien (renommez en `header_old.php`)
   - Copiez le nouveau `header.php` à la racine

2. **footer.php** :
   - Sauvegardez l'ancien
   - Copiez le nouveau `footer.php` à la racine

3. **controleur/contact_controler.php** :
   - Sauvegardez l'ancien
   - Copiez le nouveau dans `controleur/`


4. **deconnexion.php** → Racine

5. **bibliotheque.php** :
   - Renommez `bibliotheque_NEW.php` en `bibliotheque.php`
   - Placez à la racine

6. **controleur/bibliotheque_controleur.php** :
   - Créez dans le dossier `controleur/`

7. **asset/js/app.js** :
   - Copiez dans `asset/js/`

8. **asset/js/menu.js** :
   - Copiez dans `asset/js/`

9. **asset/js/compteur.js** :
   - Copiez dans `asset/js/`

#### D. CSS 
---

## 🧪 ÉTAPE 3 : TESTER (5 minutes)

### Test 1 : Menu responsive

1. Ouvrez : `http://localhost/ExamenWeb/index.php`
2. Réduisez la fenêtre
3. Vous devriez voir un bouton **☰**
4. Cliquez dessus → Le menu s'affiche

### Test 2 : Formulaire contact

1. Allez sur `/contact.php`
2. Remplissez le formulaire
3. Cliquez "Envoyer"
4. Message de succès : ✅
5. **Vérifiez dans phpMyAdmin** → Table `t_contact_con` → Votre message est là !

### Test 3 : Inscription et bibliothèque

1. Si pas encore de compte : `/inscription.php`
2. Créez un compte
3. Une fois connecté, allez sur `/bibliotheque.php`
4. Ajoutez un livre
5. Il apparaît dans la liste !
6. Testez la suppression

---


### ✅ Contact
✅ Sauvegarde dans `t_contact_con`

### ✅ Header
✅ Menu change selon connexion
✅ Lien Bibliothèque si connecté
✅ Responsive (hamburger mobile)

### ✅ Bibliothèque 
- Ajouter des livres
- Voir votre collection
- Supprimer des livres
- Lié à votre compte

### ✅ JavaScript (NOUVEAU)
- Menu responsive
- Compteur de caractères
- Console log application

---

## 🎨 AMÉLIORATIONS CSS (Optionnel)

Le nouveau CSS ajoute :
- ✅ Menu hamburger responsive
- ✅ Cartes de livres modernes
- ✅ Animations au survol
- ✅ Boutons avec transitions
- ✅ Grille adaptative

**MAIS** vous pouvez garder votre CSS actuel si vous préférez !

---

## 🐛 RÉSOLUTION DE PROBLÈMES

### Menu ne s'affiche pas en responsive ?
- Vérifiez que `asset/js/menu.js` existe
- Vérifiez que `footer.php` inclut bien les scripts

### Erreur sur bibliotheque.php ?
- Vérifiez que la table `t_livre_liv` existe
- Vérifiez que `controleur/bibliotheque_controleur.php` existe

### Contact ne sauvegarde pas ?
- Vérifiez que la table `t_contact_con` existe
- Vérifiez `controleur/contact_controler.php`

### Page blanche ?
Ajoutez en haut de `config/config.php` :
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

---

## 📋 CHECKLIST FINALE

- [ ] Tables créées dans phpMyAdmin
- [ ] Dossier `asset/js/` créé
- [ ] Fichiers JavaScript copiés
- [ ] `header.php` remplacé
- [ ] `footer.php` remplacé
- [ ] `contact_controler.php` remplacé
- [ ] `deconnexion.php` créé
- [ ] `bibliotheque.php` créé
- [ ] `bibliotheque_controleur.php` créé
- [ ] Site testé et fonctionnel

---

## 🎉 FÉLICITATIONS !

Votre site est maintenant complet avec :
- ✅ Contact qui sauvegarde en BDD
- ✅ Bibliothèque personnelle
- ✅ Menu responsive
- ✅ Compteur de caractères
- ✅ Architecture propre

**Bon codage ! 🚀**