document.getElementById('prestataireForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var formData = {
        nom: document.getElementById('nom').value,
        prenom: document.getElementById('prenom').value,
        siret: document.getElementById('siret').value,
        adresse: document.getElementById('adresse').value,
        email: document.getElementById('email').value,
        telephone: document.getElementById('telephone').value,
        domaine: document.getElementById('domaine').value
    };

    fetch('http://localhost/2A-ProjetAnnuel/PCS/API/entities/demande_prestataire.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Votre demande a été soumise avec succès !');
            } else {
                alert('Une erreur s\'est produite. Veuillez réessayer plus tard.');
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données:', error);
        });
});