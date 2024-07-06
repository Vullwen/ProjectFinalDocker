<?php include_once '../../../Site/template/header.php';
if (isAdmin()) {
    ?>

    <div class="container mt-5">
        <h2>Liste des Utilisateurs</h2>
        <input type="text" id="searchInput" class="form-control" onkeyup="searchUsers()"
            placeholder="Rechercher des utilisateurs par nom...">
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTable">
            </tbody>
        </table>
        <a href="../../index.php" class="btn btn-primary">Retour au menu Admin</a>
    </div>
    <?php
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Vous n'êtes pas autorisé à accéder à cette page.</p>";
    echo "</div>";

}
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchUsers();
    });

    function fetchUsers() {
        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data && data.length > 0) {
                    displayUsers(data);
                } else {
                    console.error('Erreur: Aucun utilisateur trouvé.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    function displayUsers(users) {
        const usersTable = document.getElementById('usersTable');
        usersTable.innerHTML = '';

        users.forEach(user => {
            const row = document.createElement('tr');

            row.innerHTML = `
            <td>${user.nom}</td>
            <td>${user.prenom}</td>
            <td>${user.email}</td>
            <td><a href="delete_user.php?email=${user.email}" class="btn btn-danger">Supprimer</a></td>
        `;

            usersTable.appendChild(row);
        });
    }


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
<?php
include_once '../../../Site/template/footer.php';