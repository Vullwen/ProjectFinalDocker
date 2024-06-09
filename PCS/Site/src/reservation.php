<?php

require_once '../../API/database/connectDB.php';
include_once '../template/header.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit();
}

$conn = connectDB();

$query = $conn->prepare("SELECT IDUtilisateur FROM utilisateur WHERE token = :token");
$query->execute(['token' => $_SESSION['token']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Une erreur s'est produite lors de la récupération de l'utilisateur.";
    exit();
}

$IDUtilisateur = $user['IDUtilisateur'];

?>
<div class="container mt-5" id="property-container">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const propertyId = urlParams.get('id');
        const userId = <?php echo json_encode($IDUtilisateur); ?>;

        if (!propertyId) {
            alert('ID du bien immobilier manquant dans l\'URL');
            return;
        }

        fetch(`../../API/routes/biens/bien.php?id=${propertyId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    alert('Erreur lors de la récupération des données');
                    return;
                }

                const property = data.property;
                displayProperty(property, propertyId);
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération des données');
            });

        function displayProperty(property, propertyId) {
            const container = document.getElementById('property-container');

            container.innerHTML = `
                <div class="property">
                    <h1>${property.Type} - ${property.Adresse}</h1>
                    <p>${property.Description.replace(/\n/g, '<br>')}</p>
                    <div class="additional-info">
                        <h2>Tarifs et frais supplémentaires</h2>
                        <p>Tarif par nuit : ${property.Tarif}€</p>
                    </div>
                    <div class="location">
                        <h2>Localisation</h2>
                        <div id="map" style="height: 300px;"></div>
                    </div>
                    <div class="reservation">
                        <h2>Réservation</h2>
                        <form id="booking-form">
                            <div class="mb-3">
                                <label for="checkin" class="form-label">Date d'arrivée</label>
                                <input type="date" class="form-control" id="checkin" required>
                            </div>
                            <div class="mb-3">
                                <label for="checkout" class="form-label">Date de départ</label>
                                <input type="date" class="form-control" id="checkout" required>
                            </div>
                            <div class="mb-3">
                                <label for="guests" class="form-label">Nombre de personnes</label>
                                <input type="number" class="form-control" id="guests" required>
                            </div>
                            <button type="button" id="reserver" class="btn btn-primary">Réserver</button>
                        </form>
                    </div>
                </div>
            `;

            initMap(property.Adresse);

            document.getElementById('reserver').addEventListener('click', function () {
                bookProperty(propertyId, property.Tarif, userId);
            });
        }

        function initMap(address) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: address }, function (results, status) {
                if (status === 'OK') {
                    const location = results[0].geometry.location;
                    const map = new google.maps.Map(document.getElementById('map'), {
                        center: location,
                        zoom: 13
                    });
                    new google.maps.Marker({
                        position: location,
                        map: map,
                        title: address
                    });
                } else {
                    document.getElementById('map').innerText = 'Localisation non disponible : ' + status;
                }
            });
        }

        function bookProperty(propertyId, propertyTarif, userId) {
            var checkin = document.getElementById('checkin').value;
            var checkout = document.getElementById('checkout').value;
            var guests = document.getElementById('guests').value;

            var reservationDetails = {
                IDUtilisateur: userId,
                IDBien: propertyId,
                DateDebut: checkin,
                DateFin: checkout,
                Description: `Réservation de ${propertyId}`,
                Tarif: propertyTarif,
                Guests: guests,
            };

            fetch('../../API/entities/reservationService.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(reservationDetails),
            })
                .then(response => response.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (error) {
                        throw new Error('Invalid JSON: ' + text);
                    }

                    if (data.message === 'Booking successful') {
                        alert('Votre réservation a été effectuée avec succès.');
                    } else {
                        alert('La réservation a échoué : ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la réservation.');
                });
        }
    });
</script>
