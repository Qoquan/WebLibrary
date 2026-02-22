<?php
$pageTitle = "Bibliothèque";
$metaDescription = "Ma bibliothèque personnelle de livres.";
require_once __DIR__ . '/controleur/bibliotheque_controleur.php';
require_once __DIR__ . '/header.php';
?>

<main class="bibliotheque-page">
    <section class="bibliotheque-section">
        <h2>📚 Ma Bibliothèque</h2>

        <?php if ($messageSucces): ?>
            <p class="success"><?= $messageSucces ?></p>
        <?php endif; ?>

        <!-- Formulaire d'ajout de livre -->
        <form method="post" class="ajout-livre-form" novalidate>
            <h3>Ajouter un livre manuellement</h3>
            
            <div class="form-row">
                <div class="form-col">
                    <label for="titre">Titre :</label>
                    <input type="text" id="titre" name="titre" 
                        value="<?= htmlspecialchars($_POST['titre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                        class="<?= isset($erreurs['titre']) ? 'erreur-champ' : '' ?>" required>
                    <p class="erreur"><?= $erreurs['titre'] ?? '' ?></p>
                </div>

                <div class="form-col">
                    <label for="auteur">Auteur :</label>
                    <input type="text" id="auteur" name="auteur" 
                        value="<?= htmlspecialchars($_POST['auteur'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                        class="<?= isset($erreurs['auteur']) ? 'erreur-champ' : '' ?>" required>
                    <p class="erreur"><?= $erreurs['auteur'] ?? '' ?></p>
                </div>
            </div>

            <label for="description">Description (optionnelle) :</label>
            <textarea id="description" name="description" 
                    rows="3"><?= htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

            <div class="buttons">
                <input id="sub" type="submit" value="Ajouter le livre">
            </div>
        </form>

        <!-- Liste des livres -->
        <div class="livres-liste">
            <h3>Mes livres (<?= count($livres) ?>)</h3>
            
            <?php if (empty($livres)): ?>
                <p class="no-books">Aucun livre pour le moment. Ajoutez-en via le formulaire ci-dessus ou via la <a href="recherche.php">recherche</a> !</p>
            <?php else: ?>
                <div class="livres-grid">
                    <?php foreach ($livres as $livre): ?>
                        <div class="livre-card">
                            <!-- Image du livre -->
                            <?php if (!empty($livre['liv_image_url'])): ?>
                                <img src="<?= htmlspecialchars($livre['liv_image_url']) ?>" 
                                     alt="<?= htmlspecialchars($livre['liv_titre']) ?>"
                                     style="width: 100%; max-width: 150px; margin: 0 auto 15px; display: block; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                            <?php else: ?>
                                <div style="width: 150px; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; border-radius: 5px; color: white; font-size: 3rem;">
                                    📖
                                </div>
                            <?php endif; ?>
                            
                            <h4><?= htmlspecialchars($livre['liv_titre']) ?></h4>
                            <p class="auteur">par <?= htmlspecialchars($livre['liv_auteur']) ?></p>
                            
                            <!-- Affichage de la note -->
                            <div class="note-display">
                                <?php 
                                $note = $livre['liv_note_personnelle'] ?? 0;
                                for ($i = 1; $i <= 5; $i++): 
                                    if ($i <= $note): ?>
                                        <span class="star filled">⭐</span>
                                    <?php else: ?>
                                        <span class="star empty">☆</span>
                                    <?php endif;
                                endfor; ?>
                                <?php if ($note > 0): ?>
                                    <span style="color: #666; font-size: 0.9em; margin-left: 5px;">(<?= $note ?>/5)</span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Affichage du commentaire -->
                            <?php if (!empty($livre['liv_commentaire_personnel'])): ?>
                                <div class="commentaire-personnel">
                                    <strong>💭 Mon avis :</strong>
                                    <p><?= nl2br(htmlspecialchars($livre['liv_commentaire_personnel'])) ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($livre['liv_description']): ?>
                                <p class="description"><?= htmlspecialchars(mb_substr($livre['liv_description'], 0, 100)) ?>...</p>
                            <?php endif; ?>
                            
                            <?php if ($livre['liv_editeur']): ?>
                                <p style="font-size: 0.85em; color: #999;">📚 <?= htmlspecialchars($livre['liv_editeur']) ?></p>
                            <?php endif; ?>
                            
                            <p class="date-ajout">Ajouté le <?= date('d/m/Y', strtotime($livre['liv_date_ajout'])) ?></p>
                            
                            <!-- Boutons d'action -->
                            <div class="actions-livre">
                                <!-- Bouton Modifier note/commentaire -->
                                <button type="button" class="btn-noter" onclick="toggleFormNote(<?= $livre['liv_id'] ?>)">
                                    ⭐ Noter / Commenter
                                </button>
                                
                                <!-- Bouton Supprimer -->
                                <form method="post" class="form-supprimer" style="display: inline-block;">
                                    <input type="hidden" name="supprimer_id" value="<?= $livre['liv_id'] ?>">
                                    <button type="submit" class="btn-supprimer" onclick="return confirm('Supprimer ce livre ?')">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Formulaire de notation (caché par défaut) -->
                            <div id="form-note-<?= $livre['liv_id'] ?>" class="form-notation" style="display: none; margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
                                <form method="post">
                                    <input type="hidden" name="livre_id" value="<?= $livre['liv_id'] ?>">
                                    
                                    <label style="display: block; margin-bottom: 10px;">
                                        <strong>⭐ Votre note :</strong>
                                    </label>
                                    <div class="note-selector">
                                        <?php for ($i = 0; $i <= 5; $i++): ?>
                                            <label class="star-label">
                                                <input type="radio" name="note" value="<?= $i ?>" 
                                                    <?= ($note == $i) ? 'checked' : '' ?>
                                                    style="display: none;">
                                                <span class="star-input" data-value="<?= $i ?>">
                                                    <?php if ($i == 0): ?>
                                                        ❌
                                                    <?php else: ?>
                                                        <?= str_repeat('⭐', $i) ?>
                                                    <?php endif; ?>
                                                </span>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                    
                                    <label style="display: block; margin-top: 15px; margin-bottom: 5px;">
                                        <strong>💭 Votre commentaire :</strong>
                                    </label>
                                    <textarea name="commentaire" rows="4" 
                                        placeholder="Qu'avez-vous pensé de ce livre ?"
                                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;"><?= htmlspecialchars($livre['liv_commentaire_personnel'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                    
                                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                                        <button type="submit" name="enregistrer_note" class="btn-valider">✅ Enregistrer</button>
                                        <button type="button" class="btn-annuler" onclick="toggleFormNote(<?= $livre['liv_id'] ?>)">❌ Annuler</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </section>
</main>

<script>
// Fonction pour afficher/masquer le formulaire de notation
function toggleFormNote(livreId) {
    const form = document.getElementById('form-note-' + livreId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

// Gestion des étoiles cliquables
document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('.star-input');
    
    starInputs.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const radio = this.previousElementSibling;
            radio.checked = true;
            
            // Mettre à jour l'affichage
            const parent = this.closest('.note-selector');
            const allStars = parent.querySelectorAll('.star-input');
            allStars.forEach(s => {
                const sValue = parseInt(s.getAttribute('data-value'));
                const currentValue = parseInt(value);
                s.style.opacity = sValue <= currentValue ? '1' : '0.3';
            });
        });
        
        // Initialiser l'affichage
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.getAttribute('data-value'));
            const parent = this.closest('.note-selector');
            const allStars = parent.querySelectorAll('.star-input');
            allStars.forEach(s => {
                const sValue = parseInt(s.getAttribute('data-value'));
                s.style.opacity = sValue <= value ? '1' : '0.3';
            });
        });
    });
    
    // Réinitialiser au survol
    document.querySelectorAll('.note-selector').forEach(selector => {
        selector.addEventListener('mouseleave', function() {
            const checked = this.querySelector('input:checked');
            if (checked) {
                const value = parseInt(checked.value);
                const allStars = this.querySelectorAll('.star-input');
                allStars.forEach(s => {
                    const sValue = parseInt(s.getAttribute('data-value'));
                    s.style.opacity = sValue <= value ? '1' : '0.3';
                });
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>