<?php
include_once '../../../Site/template/header.php';
?>

<div class="container mt-5">
    <h2>Demandes des bailleurs</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Numéro de demande</th>
                <th scope="col">Nom du propriétaire</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Email</th>
                <th scope="col">Adresse</th>
                <th scope="col">Détails</th>
            </tr>
        </thead>
        <tbody id="demandesTableBody">
        </tbody>
    </table>
</div>

<?php include_once '../../../Site/template/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('http://localhost/2A-ProjetAnnuel/PCS/API/routes/demandebiens')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const demandesTableBody = document.getElementById('demandesTableBody');

                if (data.success && Array.isArray(data.data)) {
                    if (data.data.length > 0) {
                        data.data.forEach(demande => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <th scope="row">${demande.id}</th>
                            <td>${demande.nom}</td>
                            <td>${demande.telephone}</td>
                            <td>${demande.email}</td>
                            <td>${demande.adresse}</td>
                            <td><a href="details_demande.php?id=${demande.id}">Voir détails</a></td>
                        `;
                            demandesTableBody.appendChild(row);
                        });
                    } else {
                        demandesTableBody.innerHTML = '<tr><td colspan="6">Aucune demande de bailleur n\'a été trouvée.</td></tr>';
                    }
                } else {
                    demandesTableBody.innerHTML = '<tr><td colspan="6">Erreur lors de la récupération des demandes.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des demandes:', error);
                const demandesTableBody = document.getElementById('demandesTableBody');
                demandesTableBody.innerHTML = '<tr><td colspan="6">Erreur lors de la récupération des demandes.</td></tr>';
            });
    });

</script>