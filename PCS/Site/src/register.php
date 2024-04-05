<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h2>Inscription</h2>
    <form id="registrationForm">
        <label for="nom">Nom :</label> <br>
        <input type="text" id="nom" name="nom" required> <br>
        <label for="prenom">Prénom :</label> <br>
        <input type="text" id="prenom" name="prenom" required> <br>
        <label for="email">Email :</label> <br>
        <input type="email" id="email" name="email" required> <br>
        <label for="telephone">Téléphone :</label> <br>
        <input type="tel" id="telephone" name="telephone" required> <br>
        <label for="mdp">Mot de passe :</label> <br>
        <input type="password" id="mdp" name="mdp" required> <br>
        <label for="mdp_confirm">Confirmer le mot de passe :</label> <br>
        <input type="password" id="mdp_confirm" name="mdp_confirm" required> <br>
        <input type="submit" value="S'inscrire">
    </form>

    <script>
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

        console.log(formData);

        fetch('http://localhost/PCS/API/routes/user/post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData) // Correction ici
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi des données:', error);
            });
    });
</script>

</body>

</html>