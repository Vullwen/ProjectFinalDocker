document.getElementById('registrationForm').addEventListener('submit', function (event) {
    event.preventDefault();

    var formData = {
        nom: document.getElementById('nom').value,
        prenom: document.getElementById('prenom').value,
        email: document.getElementById('email').value,
        telephone: document.getElementById('telephone').value,
        mdp: document.getElementById('mdp').value,
        mdp_confirm: document.getElementById('mdp_confirm').value
    };

    fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            const errorMessagesElement = document.getElementById('errorList');

            if (data.success && data.message) {

                alert(data.message);
                window.location.href = '../src/login.php';

            } else {
                errorMessagesElement.innerHTML = '';
                data.errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorMessagesElement.appendChild(li);
                });
            }

        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données:', error);
        });

});


