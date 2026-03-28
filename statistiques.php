<?php
// =========================================================
// Fichier : statistiques.php
// Description : Page de statistiques avec Chart.js
// =========================================================

$pageTitle = "Statistiques de ma bibliothèque";
require_once __DIR__ . '/controleur/gestionAuthentification.php';

// Redirection si non connecté
if (!est_connecte()) {
    header("Location: connexion.php");
    exit();
}

require_once __DIR__ . '/header.php';
?>

<main class="statistiques-page">
    <section class="stats-section">
        <h2>📊 Statistiques de votre bibliothèque</h2>
        
        <!-- Cartes de statistiques -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-info">
                    <h3 id="totalLivres">0</h3>
                    <p>Livres au total</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-info">
                    <h3 id="noteMoyenne">0</h3>
                    <p>Note moyenne</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">💭</div>
                <div class="stat-info">
                    <h3 id="livresCommentes">0</h3>
                    <p>Livres commentés</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">📖</div>
                <div class="stat-info">
                    <h3 id="livresMoisCourant">0</h3>
                    <p>Ajoutés ce mois-ci</p>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="charts-container">
            
            <!-- Graphique 1 : Répartition par note -->
            <div class="chart-wrapper">
                <h3>🌟 Répartition par note</h3>
                <canvas id="chartNotes"></canvas>
            </div>
            
            <!-- Graphique 2 : Évolution mensuelle -->
            <div class="chart-wrapper">
                <h3>📈 Livres ajoutés par mois</h3>
                <canvas id="chartEvolution"></canvas>
            </div>
            
            <!-- Graphique 3 : Top auteurs -->
            <div class="chart-wrapper full-width">
                <h3>✍️ Top 10 de vos auteurs préférés</h3>
                <canvas id="chartAuteurs"></canvas>
            </div>
        </div>
        
        <!-- Bouton pour rafraîchir -->
        <div class="actions">
            <button id="btnRefresh" class="btn-primary">🔄 Actualiser les statistiques</button>
        </div>
    </section>
</main>

<!-- Chargement de Chart.js depuis CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Script de statistiques -->
<script src="asset/js/statistiques.js"></script>

<style>
/* Styles pour la page de statistiques */
.statistiques-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.stats-section h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

/* Cartes de statistiques */
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 3em;
}

.stat-info h3 {
    font-size: 2.5em;
    margin: 0;
    font-weight: bold;
}

.stat-info p {
    margin: 5px 0 0 0;
    font-size: 0.9em;
    opacity: 0.9;
}

/* Conteneur des graphiques */
.charts-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.chart-wrapper {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.chart-wrapper.full-width {
    grid-column: 1 / -1;
}

.chart-wrapper h3 {
    color: #333;
    margin-bottom: 20px;
    font-size: 1.2em;
}

.chart-wrapper canvas {
    max-height: 300px;
}

/* Boutons */
.actions {
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    font-size: 1.1em;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}

/* Responsive */
@media (max-width: 768px) {
    .charts-container {
        grid-template-columns: 1fr;
    }
    
    .stats-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once __DIR__ . '/footer.php'; ?>