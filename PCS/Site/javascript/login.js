document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var formData = {
        email: document.getElementById('email').value,
        mdp: document.getElementById('mdp').value
    };

    console.log(formData);
    fetch('http://localhost/2A-ProjetAnnuel/PCS/API/routes/user/logUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données:', error);

        });
});