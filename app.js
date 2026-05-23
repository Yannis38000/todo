// Creation
document.addEventListener('DOMContentLoaded', function() {
    const formulaire = document.querySelector('#form-creer');
    
    formulaire.addEventListener('submit', function(e) {
        e.preventDefault(); // ca empeche le rechargement de page
        const donnees = new FormData(formulaire);
        fetch('api.php', {
    method: 'POST',
    body: donnees
})
.then(function(reponse) {
    return reponse.json();
})
.then(function(data) {
    console.log(data);
    location.reload(); // ca recharge juste la liste
});
    });

// Modification
document.querySelectorAll('form[id^="form-modifier"]').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const donnees = new FormData(form);
        fetch('api.php', {
            method: 'POST',
            body: donnees
        })
        .then(function(reponse) { return reponse.json(); })
        .then(function(data) { location.reload(); });
    });
});

// Suppression
document.querySelectorAll('form[id^="form-supprimer"]').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const donnees = new FormData(form);
        fetch('api.php', {
            method: 'POST',
            body: donnees
        })
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