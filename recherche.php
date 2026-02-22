<?php
$pageTitle = "Rechercher des livres";
$metaDescription = "Recherchez des livres via l'API Google Books.";
require_once __DIR__ . '/controleur/recherche_controleur.php';
require_once __DIR__ . '/header.php';
?>

<main class="recherche-page">
    <section class="recherche-section">
        <h2>🔍 Rechercher des livres</h2>
        <p style="text-align: center; color: #666;">Recherchez des livres via Google Books et ajoutez-les à votre bibliothèque</p>

        <!-- Formulaire de recherche -->
        <form method="get" class="recherche-form">
            <div style="display: flex; gap: 10px; max-width: 600px; margin: 0 auto;">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Titre, auteur, ISBN..." 
                    value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                    style="flex: 1;"
                >
                <button type="submit" id="sub">🔍 Rechercher</button>
            </div>
        </form>

        <?php if ($messageSucces): ?>
            <p class="success"><?= $messageSucces ?></p>
        <?php endif; ?>

        <?php if ($messageErreur): ?>
            <p class="erreur"><?= $messageErreur ?></p>
        <?php endif; ?>

        <!-- Résultats de recherche -->
        <?php if (!empty($resultats)): ?>
            <div class="resultats-section">
                <h3>Résultats de recherche (<?= count($resultats) ?>)</h3>
                
                <div class="livres-grid">
                    <?php foreach ($resultats as $livre): ?>
                        <div class="livre-card">
                            <?php if (!empty($livre['image'])): ?>
                                <img src="<?= htmlspecialchars($livre['image']) ?>" 
                                     alt="<?= htmlspecialchars($livre['titre']) ?>"
                                     style="width: 100%; max-width: 150px; margin: 0 auto 15px; display: block; border-radius: 5px;">
                            <?php else: ?>
                                <div style="width: 150px; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; border-radius: 5px; color: white; font-size: 3rem;">
                                    📖
                                </div>
                            <?php endif; ?>
                            
                            <h4><?= htmlspecialchars($livre['titre']) ?></h4>
                            <p class="auteur">par <?= htmlspecialchars($livre['auteur']) ?></p>
                            
                            <?php if (!empty($livre['description'])): ?>
                                <p class="description">
                                    <?= htmlspecialchars(mb_substr($livre['description'], 0, 150)) ?>...
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($livre['editeur'])): ?>
                                <p style="font-size: 0.85em; color: #999;">
                                    📚 <?= htmlspecialchars($livre['editeur']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($livre['date_publication'])): ?>
                                <p style="font-size: 0.85em; color: #999;">
                                    📅 <?= htmlspecialchars($livre['date_publication']) ?>
                                </p>
                            <?php endif; ?>
                            
                            <!-- Formulaire d'ajout à la bibliothèque -->
                            <form method="post" style="margin-top: 15px; padding: 0; background: none; box-shadow: none;">
                                <input type="hidden" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>">
                                <input type="hidden" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>">
                                <input type="hidden" name="description" value="<?= htmlspecialchars($livre['description'] ?? '') ?>">
                                <input type="hidden" name="editeur" value="<?= htmlspecialchars($livre['editeur'] ?? '') ?>">
                                <input type="hidden" name="date_publication" value="<?= htmlspecialchars($livre['date_publication'] ?? '') ?>">
                                <input type="hidden" name="image_url" value="<?= htmlspecialchars($livre['image'] ?? '') ?>">
                                <input type="hidden" name="ajouter_livre" value="1">
                                
                                <button type="submit" id="sub" style="width: 100%;">
                                    ➕ Ajouter à ma bibliothèque
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif (isset($_GET['q'])): ?>
            <p style="text-align: center; color: #666; margin-top: 40px;">
                Aucun résultat trouvé pour "<?= htmlspecialchars($_GET['q']) ?>"
            </p>
        <?php endif; ?>

    </section>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>