<?php include_once '../../../Site/template/header.php';
require_once '../../../API/database/connectDB.php'; ?>

<div class="container mt-5">
    <h2>Liste des Utilisateurs</h2>
    <input type="text" id="searchInput" class="form-control" onkeyup="searchUsers()"
        placeholder="Rechercher des utilisateurs...">
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody id="usersTable">
            <?php

            $db = connectDB();
            $query = $db->query("SELECT Nom, Prenom, Email FROM utilisateur");

            while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$user['Nom']}</td>";
                echo "<td>{$user['Prenom']}</td>";
                echo "<td>{$user['Email']}</td>";
                echo "<td><a href='delete_user.php?email={$user['Email']}' class='btn btn-danger'>Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="../../index.php" class="btn btn-primary">Retour au menu Admin</a>
</div>

<script>
    function searchUsers() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("usersTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];

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