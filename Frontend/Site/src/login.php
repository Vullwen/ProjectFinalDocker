<?php
include_once '../template/header.php';
?>

<body>
    <h2>Connexion</h2>
    <form id="loginForm" action="../functions/login.php" method="GET">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required>
        <input type="submit" value="Se connecter">
    </form>

    <?php
    include_once '../template/footer.php';