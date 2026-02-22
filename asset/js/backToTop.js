/**
 * BACK TO TOP - Bouton retour en haut de page
 * Apparaît quand on scrolle, remonte en douceur
 */

document.addEventListener('DOMContentLoaded', function() {
    
    const backToTopBtn = document.getElementById('backToTop');
    
    if (!backToTopBtn) {
        console.warn('Bouton #backToTop non trouvé');
        return;
    }
    
    // Afficher/masquer le bouton selon le scroll
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    });
    
    // Clic sur le bouton : remonter en douceur
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Animation fluide
        });
    });
    
    // Alternative pour navigateurs anciens
    if (!('scrollBehavior' in document.documentElement.style)) {
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const scrollToTop = function() {
                const currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
                if (currentScroll > 0) {
                    window.requestAnimationFrame(scrollToTop);
                    window.scrollTo(0, currentScroll - currentScroll / 8);
                }
            };
            scrollToTop();
        });
    }
});