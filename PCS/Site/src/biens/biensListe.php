<?php

if (!isset($_SESSION['estBailleur']) || $_SESSION['estBailleur'] != 1) {
    header("Location: /2A-ProjetAnnuel/PCS/Site/src/login.php");
    exit;
}

include_once "../../template/header.php";
var_dump($_SESSION);
?>

<div class='container mt-5'>
    <h2>Liste de vos biens immobiliers</h2>
    <table class='table' id='biensTable'>
        <thead>
            <tr>
                <th scope='col'>Type</th>
                <th scope='col'>Adresse</th>
                <th scope='col'>Description</th>
                <th scope='col'>Superficie</th>
                <th scope='col'>Nombre de chambres</th>
                <th scope='col'>Tarif</th>
                <th scope='col'>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class='container mt-2 btn-center'>
        <a class='btn btn-primary' href='/2A-ProjetAnnuel/PCS/Site/src/biens/ajoutBiens.php'>Ajouter un bien</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = '<?php echo $_SESSION['token']; ?>';
        const headers = new Headers({
            'Authorization': 'Bearer ' + token
        });

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id', { headers: headers })
            .then(response => response.json())
            .then(userData => {
                if (!userData || !userData.user_id) {
                    throw new Error('Erreur lors de la récupération de l\'utilisateur');
                }
                return userData.user_id;
            })
            .then(user_id => {
                return fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/listeBiensProprietaires?id=' + user_id)
                    .then(response => response.json())
            })
            .then(data => {
                const biensTable = document.getElementById('biensTable').getElementsByTagName('tbody')[0];
                if (data.property && data.property.length > 0) {
                    data.property.forEach(bien => {
                        const row = biensTable.insertRow();
                        row.insertCell(0).innerText = bien.Type_bien;
                        row.insertCell(1).innerText = bien.Adresse;
                        row.insertCell(2).innerText = bien.Description;
                        row.insertCell(3).innerText = bien.Superficie;
                        row.insertCell(4).innerText = bien.NbChambres;
                        row.insertCell(5).innerText = bien.Tarif + ' € / nuit';
                        const actionsCell = row.insertCell(6);
                        const detailsLink = document.createElement('a');
                        detailsLink.href = '/2A-ProjetAnnuel/PCS/Site/src/biens/details_bien.php?id=' + bien.IDBien;
                        detailsLink.className = 'btn btn-primary';
                        detailsLink.innerText = 'Détails';
                        actionsCell.appendChild(detailsLink);
                    });
                } else {
                    const container = document.createElement('div');
                    container.className = 'container mt-5';
                    container.innerHTML = '<p>Vous n\'avez pas encore ajouté de bien immobilier.</p>';
                    document.body.insertBefore(container, document.getElementById('biensTable').parentNode);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                const container = document.createElement('div');
                container.className = 'container mt-5';
                container.innerHTML = '<p>Une erreur s\'est produite lors de la récupération de vos biens immobiliers.</p>';
                document.body.insertBefore(container, document.getElementById('biensTable').parentNode);
            });
    });
</script>

<?php
include_once "../../template/footer.php";
?>