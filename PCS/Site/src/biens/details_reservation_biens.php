<?php
include_once '../../template/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Détails de la réservation</h2>
    <div id="reservation-details" class="card">
        <div class="card-body">
            <h5 class="card-title" id="reservation-title"></h5>
            <p class="card-text" id="reservation-description"></p>
            <ul class="list-group list-group-flush" id="reservation-info">
            </ul>
            <button id="toggle-coordonnees" class="btn btn-info mt-3">Afficher les coordonnées</button>
            <div id="coordonnees" class="mt-3" style="display: none;">
                <p>Email: <span id="client-email"></span></p>
                <p>Téléphone: <span id="client-telephone"></span></p>
            </div>

            <div class="mt-4">
                <button id="delete-reservation" class="btn btn-danger">Supprimer</button>
                <button id="accept-reservation" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <a href="biensListe.php" class="btn btn-primary">Retour</a>
    </div>
</div>

<?php
include_once '../../template/footer.php';
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const reservationId = <?php echo json_encode($_GET['id']); ?>;

        fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/reservation/details?id=${reservationId}`, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + <?php echo json_encode($_SESSION['token']); ?>,
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP! Statut : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const reservation = data.reservation;

                    const dateDebut = new Date(reservation.DateDebut);
                    const dateFin = new Date(reservation.DateFin);
                    const interval = (dateFin - dateDebut) / (1000 * 3600 * 24);
                    const prixTotal = interval * reservation.Tarif;
                    const formatter = new Intl.DateTimeFormat('fr', { year: 'numeric', month: '2-digit', day: '2-digit' });

                    document.getElementById('reservation-title').textContent = `Réservation du ${formatter.format(dateDebut)} au ${formatter.format(dateFin)}`;
                    document.getElementById('reservation-description').textContent = `Nombre de voyageurs : ${reservation.NbVoyageurs}`;
                    document.getElementById('reservation-info').innerHTML = `
                    <li class="list-group-item">Prix total : ${prixTotal} €</li>
                    <li class="list-group-item">Client : ${reservation.nom}</li>
                    <li class="list-group-item">Status : ${reservation.Status}</li>
                `;
                    document.getElementById('client-email').textContent = reservation.email;
                    document.getElementById('client-telephone').textContent = reservation.telephone;

                    document.getElementById('toggle-coordonnees').addEventListener('click', () => {
                        const coordonnees = document.getElementById('coordonnees');
                        coordonnees.style.display = coordonnees.style.display === 'none' ? 'block' : 'none';
                    });

                    document.getElementById('delete-reservation').addEventListener('click', () => handleAction('delete', reservationId));
                    if (reservation.Status === 'Accepted') {
                        document.getElementById('accept-reservation').style.display = 'none';
                    }

                    document.getElementById('accept-reservation').addEventListener('click', () => handleAction('accept', reservationId));
                } else {
                    alert('Erreur lors de la récupération de la réservation.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération de la réservation.');
            });
    });

    function handleAction(action, reservationId) {
        let endpoint = '';
        if (action === 'delete') {
            endpoint = `http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/biens/delete_reservation.php`;
            window.location.href = 'biensListe.php';
        } else if (action === 'accept') {
            endpoint = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/biens/accept_reservation.php`;
        }

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idReservation: reservationId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    console.error('Erreur:', data.message);
                }
            })
            .catch((error) => {
                console.error('Erreur:', error);
            });
    }
</script>