/**
 * COMPTEUR.JS - Compteur de caractères
 * Affiche le nombre de caractères dans les champs message
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Chercher les champs de type textarea
    const textareas = document.querySelectorAll('textarea');
    
    textareas.forEach(function(textarea) {
        
        // Créer l'élément compteur
        const counter = document.createElement('div');
        counter.className = 'char-counter';
        counter.style.textAlign = 'right';
        counter.style.fontSize = '0.9em';
        counter.style.color = '#666';
        counter.style.marginTop = '5px';
        
        // Insérer après le textarea
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);
        
        // Fonction de mise à jour
        function updateCounter() {
            const length = textarea.value.length;
            const maxLength = textarea.getAttribute('maxlength') || 3000;
            counter.textContent = length + ' / ' + maxLength + ' caractères';
            
            // Changer la couleur si proche de la limite
            if (length > maxLength * 0.9) {
                counter.style.color = '#d00';
            } else if (length > maxLength * 0.7) {
                counter.style.color = '#f90';
            } else {
                counter.style.color = '#666';
            }
        }
        
        // Mise à jour lors de la saisie
        textarea.addEventListener('input', updateCounter);
        
        // Initialiser
        updateCounter();
    });
});