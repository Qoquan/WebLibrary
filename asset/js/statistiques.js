// =========================================================
// Fichier : asset/js/statistiques.js
// Description : Gestion des statistiques avec Fetch API et Chart.js
// =========================================================

// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('📊 Module statistiques chargé');
    
    // Initialiser les graphiques
    let chartNotes = null;
    let chartEvolution = null;
    let chartAuteurs = null;
    
    // Charger les statistiques au démarrage
    chargerStatistiques();
    
    // Bouton de rafraîchissement
    const btnRefresh = document.getElementById('btnRefresh');
    if (btnRefresh) {
        btnRefresh.addEventListener('click', function() {
            console.log('🔄 Actualisation des statistiques...');
            chargerStatistiques();
        });
    }
    
    /**
     * Charge les statistiques via Fetch API
     */
    function chargerStatistiques() {
        // Afficher un loader
        afficherLoader(true);
        
        // Requête Fetch vers l'API
        fetch('api/statistiques.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin' // Envoyer les cookies de session
        })
        .then(response => {
            console.log('📡 Réponse reçue, statut:', response.status);
            
            // Vérifier si la réponse est OK
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            
            // Parser le JSON
            return response.json();
        })
        .then(data => {
            console.log('✅ Données reçues:', data);
            
            // Vérifier le succès
            if (data.success) {
                afficherStatistiques(data.data);
            } else {
                throw new Error(data.error || 'Erreur inconnue');
            }
        })
        .catch(error => {
            console.error('❌ Erreur lors du chargement:', error);
            afficherErreur('Impossible de charger les statistiques: ' + error.message);
        })
        .finally(() => {
            afficherLoader(false);
        });
    }
    
    /**
     * Affiche les statistiques dans la page
     */
    function afficherStatistiques(data) {
        console.log('📊 Affichage des statistiques...');
        
        // ================================
        // 1. STATISTIQUES GÉNÉRALES
        // ================================
        
        const general = data.general;
        
        // Animation des chiffres
        animer('totalLivres', 0, general.totalLivres, 1000);
        animer('noteMoyenne', 0, general.noteMoyenne, 1000, 1);
        animer('livresCommentes', 0, general.livresCommentes, 1000);
        animer('livresMoisCourant', 0, general.livresMoisCourant, 1000);
        
        // ================================
        // 2. GRAPHIQUE RÉPARTITION NOTES
        // ================================
        
        const ctxNotes = document.getElementById('chartNotes');
        if (ctxNotes) {
            // Détruire le graphique existant
            if (chartNotes) {
                chartNotes.destroy();
            }
            
            chartNotes = new Chart(ctxNotes, {
                type: 'doughnut',
                data: {
                    labels: data.notes.labels,
                    datasets: [{
                        label: 'Nombre de livres',
                        data: data.notes.data,
                        backgroundColor: [
                            '#ff6384',  // 0 étoile - Rouge
                            '#ff9f40',  // 1 étoile - Orange
                            '#ffcd56',  // 2 étoiles - Jaune
                            '#4bc0c0',  // 3 étoiles - Turquoise
                            '#36a2eb',  // 4 étoiles - Bleu
                            '#9966ff'   // 5 étoiles - Violet
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        title: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} livres (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // ================================
        // 3. GRAPHIQUE ÉVOLUTION MENSUELLE
        // ================================
        
        const ctxEvolution = document.getElementById('chartEvolution');
        if (ctxEvolution) {
            if (chartEvolution) {
                chartEvolution.destroy();
            }
            
            chartEvolution = new Chart(ctxEvolution, {
                type: 'line',
                data: {
                    labels: data.evolution.labels,
                    datasets: [{
                        label: 'Livres ajoutés',
                        data: data.evolution.data,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} livre(s) ajouté(s)`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return value + ' livre' + (value > 1 ? 's' : '');
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // ================================
        // 4. GRAPHIQUE TOP AUTEURS
        // ================================
        
        const ctxAuteurs = document.getElementById('chartAuteurs');
        if (ctxAuteurs) {
            if (chartAuteurs) {
                chartAuteurs.destroy();
            }
            
            chartAuteurs = new Chart(ctxAuteurs, {
                type: 'bar',
                data: {
                    labels: data.auteurs.labels,
                    datasets: [{
                        label: 'Nombre de livres',
                        data: data.auteurs.data,
                        backgroundColor: 'rgba(102, 126, 234, 0.8)',
                        borderColor: '#667eea',
                        borderWidth: 2,
                        borderRadius: 8,
                        barThickness: 'flex',
                        maxBarThickness: 80
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    indexAxis: 'y', // Barres horizontales
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.x} livre(s)`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }
        
        console.log('✅ Statistiques affichées avec succès');
    }
    
    /**
     * Anime un chiffre de start à end
     */
    function animer(elementId, start, end, duration, decimals = 0) {
        const element = document.getElementById(elementId);
        if (!element) return;
        
        const range = end - start;
        const increment = range / (duration / 16); // 60 FPS
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = current.toFixed(decimals);
        }, 16);
    }
    
    /**
     * Affiche/masque le loader
     */
    function afficherLoader(visible) {
        const btn = document.getElementById('btnRefresh');
        if (btn) {
            if (visible) {
                btn.disabled = true;
                btn.innerHTML = '⏳ Chargement...';
            } else {
                btn.disabled = false;
                btn.innerHTML = '🔄 Actualiser les statistiques';
            }
        }
    }
    
    /**
     * Affiche un message d'erreur
     */
    function afficherErreur(message) {
        // Créer une notification d'erreur
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff6b6b;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = '❌ ' + message;
        
        document.body.appendChild(notification);
        
        // Supprimer après 5 secondes
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
});

// Animations CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);