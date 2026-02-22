/**
 * MENU.JS - Menu responsive
 * Gestion du menu hamburger sur mobile
 */

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const mainNav = document.getElementById('mainNav');
    
    if (menuToggle && mainNav) {
        
        // Clic sur le bouton hamburger
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            
            // Changer l'icône
            if (mainNav.classList.contains('active')) {
                menuToggle.textContent = '✕';
            } else {
                menuToggle.textContent = '☰';
            }
        });
        
        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !mainNav.contains(e.target)) {
                mainNav.classList.remove('active');
                menuToggle.textContent = '☰';
            }
        });
    }
});