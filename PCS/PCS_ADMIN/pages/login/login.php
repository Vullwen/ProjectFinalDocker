<?php
session_start(); // Ajoutez cette ligne au début du fichier
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin PCS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style_login.css" rel="stylesheet">
</head>
<body class="d-flex flex-column vh-100">

<header class="container-fluid bg-dark text-white p-3 text-center">
    Paris Caretaker Services
</header>

<div class="container h-100 d-flex align-items-center justify-content-center">
    <div class="login-form bg-light p-5 rounded shadow">
        <form action="check_login.php" method="post">
            <h2 class="text-center mb-4">Connexion Admin</h2>
            <!-- Afficher le message d'erreur ici -->
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']); // Supprime le message d'erreur après l'affichage
                    ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Connexion</button>
        </form>
    </div>
</div>


<footer class="text-center py-4" style="background-color: #003366; color: #DAA520;">
  <p>© 2024 Paris Caretaker Services. Tous droits réservés.</p>
</footer>

<!-- Bootstrap JS et Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
