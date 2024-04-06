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
            if (data.success && data.message) {

                window.location.href = '../#.php';

            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des données:', error);

        });
});