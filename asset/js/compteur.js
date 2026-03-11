/**
 * COMPTEUR.JS - Compteur de caractères (version classe)
 */

class CharCounter {

    constructor(selector = 'textarea') {
        this.textareas = document.querySelectorAll(selector);
        this.init();
    }

    init() {
        this.textareas.forEach(textarea => {
            this.createCounter(textarea);
        });
    }

    createCounter(textarea) {
        // Création du compteur
        const counter = document.createElement('div');
        counter.className = 'char-counter';
        counter.style.textAlign = 'right';
        counter.style.fontSize = '0.9em';
        counter.style.color = '#666';
        counter.style.marginTop = '5px';

        // Insérer après le textarea
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);

        // Listener
        textarea.addEventListener('input', () => {
            this.updateCounter(textarea, counter);
        });

        // Initialisation
        this.updateCounter(textarea, counter);
    }

    updateCounter(textarea, counter) {
        const length = textarea.value.length;
        const maxLength = textarea.getAttribute('maxlength') || 3000;

        counter.textContent = `${length} / ${maxLength} caractères`;

        // Gestion des couleurs
        if (length > maxLength * 0.9) {
            counter.style.color = '#d00';
        } else if (length > maxLength * 0.7) {
            counter.style.color = 'rgb(195, 119, 4)';
        } else {
            counter.style.color = '#666';
        }
    }
}


// Initialisation au chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    new CharCounter();
});