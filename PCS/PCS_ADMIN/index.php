<?php
session_start();

// Vérifiez si l'utilisateur est déjà connecté
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === false) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: pages/login/login.php");
    exit();
}
 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="img\LOGO.png" alt="LOGO" width="70px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
        <li class="nav-item">
          <a class="nav-link" href="#">Connexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">
    <h2>Tableau de Bord Admin</h2>
    <div class="row">
        <!-- Gestion des utilisateurs -->
        <div class="col-md-4">
            <div class="card" onclick="window.location.href='pages/users/userlist.php';" style="cursor: pointer;">
                <img src="img/users_icon.png" class="card-img-top" alt="Gestion des utilisateurs">
                <div class="card-body">
                    <h5 class="card-title">Gestion des utilisateurs</h5>
                    <p class="card-text">Ajouter, modifier et supprimer des utilisateurs.</p>
                </div>
            </div>
        </div>
        <!-- Gestion des biens -->
        <div class="col-md-4">
            <div class="card" onclick="window.location.href='pages/biens/bien.php';" style="cursor: pointer;">
                <img src="img/properties_icon.png" class="card-img-top" alt="Gestion des biens">
                <div class="card-body">
                    <h5 class="card-title">Gestion des biens</h5>
                    <p class="card-text">Ajouter, modifier et supprimer des biens immobiliers.</p>
                </div>
            </div>
        </div>
        <!-- Ajoutez plus de sections ici si nécessaire -->
    </div>
</div>

<!-- Bootstrap JS et ses dépendances (Optionnel) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
