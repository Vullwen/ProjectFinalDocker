<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Liste des Utilisateurs</h2>
    <input type="text" id="searchInput" class="form-control" onkeyup="searchUsers()" placeholder="Rechercher des utilisateurs...">
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <!-- Autres colonnes si nécessaire -->
            </tr>
        </thead>
        <tbody id="usersTable">
            <?php
            // Connectez-vous à votre base de données et récupérez tous les utilisateurs
            require_once '../../database/connectDB.php'; // Assurez-vous que ce chemin est correct
            $db = connectDB();
            $query = $db->query("SELECT Nom, Prenom, Email FROM utilisateur");

            while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$user['Nom']}</td>";
                echo "<td>{$user['Prenom']}</td>";
                echo "<td>{$user['Email']}</td>";
                // Affichez d'autres informations si nécessaire
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function searchUsers() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("usersTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0]; // Recherchez dans la première colonne
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
