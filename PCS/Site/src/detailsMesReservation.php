<?php
include_once '../template/header.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit();
}
?>
<div class="container mt-5">
    <h2>Détails de la reservation</h2>
    <div id="reservations-content"></div>
    <a href="mesReservation.php" class="btn btn-primary">Retour</a>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const idReservation = <?php echo json_encode($_GET['id']); ?>;

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/reservation/details?id=' + idReservation, {
            method: 'GET'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    document.getElementById('reservations-content').innerHTML = '<p>Aucune réservation trouvée pour cet utilisateur.</p>';
                    return;
                }
                console.log(data.reservation);
                displayReservations(data.reservation);
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération des réservations');
            });
    });

    function displayReservations(reservation) {
        const container = document.getElementById('reservations-content');
        if (reservation.length === 0) {
            container.innerHTML = '<p>Aucune réservation n\'a été trouvée.</p>';
            return;
        }
        const dateDebut = new Date(reservation.DateDebut);
        const dateFin = new Date(reservation.DateFin);
        dateDebut.setHours(0, 0, 0, 0);
        dateFin.setHours(0, 0, 0, 0);

        const timeDiff = Math.abs(dateFin.getTime() - dateDebut.getTime());
        const nbJours = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
        const prixTotal = reservation.Tarif * nbJours;

        const table = document.createElement('table');
        table.classList.add('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th scope="col">Adresse du logement</th>
                    <th scope="col">Date de début</th>
                    <th scope="col">Date de fin</th>
                    <th scope="col">Nombre de voyageurs</th>
                    <th scope="col">Tarif par jour</th>
                    <th scope="col">Prix total</th>
                    <th scope="col">Client</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="reservations-body">
            </tbody>
        `;
        container.appendChild(table);

        const reservationsTable = document.getElementById('reservations-body');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${reservation.adresse}</td>
            <td>${reservation.DateDebut}</td>
            <td>${reservation.DateFin}</td>
            <td>${reservation.NbVoyageurs}</td>
            <td>${reservation.Tarif}</td>
            <td>${prixTotal}</td>
            <td>${reservation.nom}</td>
            <td>${reservation.Status}</td>
            <td>
                <button class="btn btn-danger" onclick="cancelReservation(${reservation.IDReservation})">Annuler</button>
            </td>
        `;
        reservationsTable.appendChild(row);

    }

    function cancelReservation(id) {
        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/reservation?id=' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: id
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('La réservation a été annulée avec succès.');
                    window.location.href = 'mesReservation.php';
                } else {
                    alert('Erreur lors de l\'annulation de la réservation.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'annulation de la réservation.');
            });
    }

</script>