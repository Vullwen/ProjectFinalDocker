<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Biens Immobiliers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .card:hover {
            transform: scale(1.05); /* Agrandit la carte */
            transition: transform 0.3s ease-in-out; /* Animation de l'agrandissement */
        }
        .search-box {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Liste des Biens Immobiliers</h2>
    <div class="search-box">
        <input type="text" id="searchInputBiens" class="form-control" onkeyup="searchBiens()" placeholder="Rechercher des biens...">
    </div>
    <div class="row" id="biensContainer">
        <?php
        require_once '../../database/connectDB.php'; // Assurez-vous que ce chemin est correct
        $db = connectDB();
        $query = $db->query("SELECT * FROM bienimmobilier");

        while ($bien = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card' style='cursor: pointer;'>";
            echo "<img src='img/bien_placeholder.png' class='card-img-top' alt='...'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$bien['Type']}</h5>";
            echo "<p class='card-text'>Adresse: {$bien['Adresse']}</p>";
            echo "<p class='card-text'>Description: {$bien['Description']}</p>";
            echo "<p class='card-text'>Superficie: {$bien['Superficie']}</p>";
            echo "<p class='card-text'>Nombre de Chambres: {$bien['NbChambres']}</p>";
            echo "<p class='card-text'>Tarif: {$bien['Tarif']}</p>";
            // Ajoutez un bouton ou un lien pour plus d'actions ici
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function searchBiens() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInputBiens");
    filter = input.value.toUpperCase();
    table = document.getElementById("biensTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0]; // Recherche dans la colonne 'Adresse'
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}
</script>
</body>
</html>
