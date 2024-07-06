<?php
include_once '../template/header.php';
?>

<body>
    <h2>Inscription</h2>
    <form id="registrationForm">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required>
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required>
        <label for="mdp_confirm">Confirmer le mot de passe :</label>
        <input type="password" id="mdp_confirm" name="mdp_confirm" required>
        <input type="submit" value="S'inscrire">
    </form>

    <div id="errorMessages">
        <ul id="errorList"></ul>
    </div>


    <script src="../javascript/inscription.js"></script>

</body>

</html>