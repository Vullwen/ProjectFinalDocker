<?php
include_once '../Site/template/header.php';
?>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>