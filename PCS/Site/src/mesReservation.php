<?php
require_once '../template/header.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit();
}
?>
<div class="container mt-5">
    <h2>Mes Réservations</h2>
    <div id="reservations-content"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = <?php echo json_encode($_SESSION['token']); ?>;

        fetch('http://localhost/2A-ProjetAnnuel/PCS/API/user/id', {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + token }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    alert('Erreur lors de la récupération de l\'ID de l\'utilisateur');
                    return;
                }
                const userId = data.user_id;
                return fetch('http://localhost/2A-ProjetAnnuel/PCS/API/reservation?id=' + userId, {
                    method: 'GET'
                });
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
                displayReservations(data.data);
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération des réservations');
            });
    });

    function displayReservations(reservations) {
        const container = document.getElementById('reservations-content');
        if (reservations.length === 0) {
            container.innerHTML = '<p>Aucune réservation n\'a été trouvée.</p>';
            return;
        }

        let table = '<table class="table table-striped">';
        table += '<thead><tr>';
        table += '<th scope="col">Numéro de réservation</th>';
        table += '<th scope="col">Nom de la propriété</th>';
        table += '<th scope="col">Date d\'arrivée</th>';
        table += '<th scope="col">Date de départ</th>';
        table += '<th scope="col">Statut</th>';
        table += '<th scope="col">Actions</th>';
        table += '</tr></thead>';
        table += '<tbody>';

        reservations.forEach(reservation => {
            console.log(reservation);
            table += '<tr>';
            table += '<th scope="row">' + reservation.IDReservation + '</th>';
            table += '<td>' + reservation.adresse + '</td>';
            table += '<td>' + reservation.DateDebut + '</td>';
            table += '<td>' + reservation.DateFin + '</td>';
            table += '<td>' + reservation.Status + '</td>';
            table += '<td><button class="btn btn-primary btn-sm" onclick="voirDetails(' + reservation.IDReservation + ')">Voir détails</button></td>';
            table += '</tr>';
        });

        table += '</tbody></table>';
        container.innerHTML = table;
    }

    function voirDetails(id) {
        window.location.href = 'detailsMesReservation.php?id=' + id;
    }

</script>