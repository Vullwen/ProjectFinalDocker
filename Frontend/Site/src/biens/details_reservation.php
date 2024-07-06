<?php
include_once '../../template/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Liste des réservations liées au bien</h2>
    <table id="reservations-table" class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Date de début</th>
                <th scope="col">Date de fin</th>
                <th scope="col">Nombre de voyageurs</th>
                <th scope="col">Prix total</th>
                <th scope="col">Client</th>
                <th scope="col">Statut</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody id="reservations-body">
        </tbody>
    </table>
</div>

<?php
include_once '../../template/footer.php';
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const bienId = <?php echo json_encode($_GET['id']); ?>;

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id', {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + <?php echo json_encode($_SESSION['token']); ?> }
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

                const apiEndpoint = `http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/reservations?bienId=${bienId}&userId=${userId}`;

                return fetch(apiEndpoint, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer <?php echo json_encode($_SESSION['token']); ?>',
                        'Content-Type': 'application/json'
                    }
                });
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP! Statut : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const reservationsTable = document.getElementById('reservations-body');
                reservationsTable.innerHTML = '';

                if (data.success) {
                    const reservations = data.reservations;
                    const formatter = new Intl.DateTimeFormat('fr', { year: 'numeric', month: '2-digit', day: '2-digit' });

                    reservations.forEach(reservation => {
                        const dateDebut = new Date(reservation.DateDebut);
                        const dateFin = new Date(reservation.DateFin);
                        const interval = (dateFin - dateDebut) / (1000 * 3600 * 24);
                        const prixTotal = interval * reservation.Tarif;

                        reservationsTable.innerHTML += `
                        <tr>
                            <td class="align-middle">${formatter.format(dateDebut)}</td>
                            <td class="align-middle">${formatter.format(dateFin)}</td>
                            <td class="align-middle text-center">${reservation.NbVoyageurs}</td>
                            <td class="align-middle">${prixTotal} €</td>
                            <td class="align-middle">${reservation.nom}
                                <button class="btn btn-info btn-sm ml-2" type="button" onclick="toggleCoordonnees(${reservation.IDReservation})">
                                    Coordonnées
                                </button>
                                <div id="coordonnees-${reservation.IDReservation}" class="coordonnees" style="display:none;">
                                    <p>Email: ${reservation.email}</p>
                                    <p>Téléphone: ${reservation.telephone}</p>
                                </div>
                            </td>
                            <td class="align-middle">${reservation.Status}</td>
                            <td class="align-middle">
                                <a href="/2A-ProjetAnnuel/PCS/Site/src/biens/details_reservation_biens.php?id=${reservation.IDReservation}" class="btn btn-primary">Gérer</a>
                            </td>
                        </tr>
                    `;
                    });
                } else {
                    reservationsTable.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">Aucune réservation trouvée pour ce bien.</td>
                    </tr>
                `;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération des réservations.');
            });
    });

    function toggleCoordonnees(id) {
        const element = document.getElementById(`coordonnees-${id}`);
        if (element.style.display === 'none') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    }
</script>