document.addEventListener('DOMContentLoaded', function() {

    // Creation
    const formulaire = document.querySelector('#form-creer');
    formulaire.addEventListener('submit', function(e) {
        e.preventDefault();
        const donnees = new FormData(formulaire);
        fetch('api.php', { method: 'POST', body: donnees })
        .then(function(reponse) { return reponse.json(); })
        .then(function(data) { location.reload(); });
    });

    // Modification
    document.querySelectorAll('form[id^="form-modifier"]').forEach(function(form) {
        form.style.display = 'none';
        const bouton = document.createElement('button');
        bouton.textContent = 'Modifier';
        bouton.type = 'button';
        bouton.addEventListener('click', function() {
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
        form.insertAdjacentElement('beforebegin', bouton);
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const donnees = new FormData(form);
            fetch('api.php', { method: 'POST', body: donnees })
            .then(function(reponse) { return reponse.json(); })
            .then(function(data) { location.reload(); });
        });
    });

    // Suppression
    document.querySelectorAll('form[id^="form-supprimer"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const donnees = new FormData(form);
            fetch('api.php', { method: 'POST', body: donnees })
            .then(function(reponse) { return reponse.json(); })
            .then(function(data) { location.reload(); });
        });
    });

    // Tache terminee
    document.querySelectorAll('form[id^="form-terminer"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const donnees = new FormData(form);
            fetch('api.php', { method: 'POST', body: donnees })
            .then(function(reponse) { return reponse.json(); })
            .then(function(data) { location.reload(); });
        });
    });

});