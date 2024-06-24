<?php
require_once "../template/header.php";
?>
<div class="container mt-5">
    <div id="property-details">
        <h1 id="property-title"></h1>
        <p id="property-description"></p>
        <div id="additional-info">
            <h2>Tarifs et frais supplémentaires</h2>
            <p id="property-tarif"></p>
            <div id="prestataire-select"></div>
        </div>
        <div id="location-info">
            <h2>Localisation</h2>
            <div id="map" style="height: 300px;"></div>
        </div>
        <div id="reservation-form">
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new
            URLSearchParams(window.location.search); const propertyId = urlParams.get('id'); if (!propertyId) {
                alert('ID du bien immobilier manquant dans l\'URL'); return;
            }
        fetch(`../../API/routes/biens/get.php?id=${propertyId}`).then(response => {
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

                document.getElementById('property-title').textContent = `${property.Type} - ${property.Adresse}`;
                document.getElementById('property-description').innerHTML = property.Description.replace(/\n/g, '<br>');
                document.getElementById('property-tarif').textContent = `Tarif par nuit : ${property.Tarif}€`;

                fetch(`http://localhost/2A-ProjetAnnuel/PCS/API/prestataires`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data.success) {
                            throw new Error('Erreur lors de la récupération des données des prestataires');
                        }

                        const prestataires = data.data;

                        const selectPrestataire = document.createElement('select');
                        selectPrestataire.classList.add('form-select');
                        selectPrestataire.setAttribute('id', 'prestataire');
                        selectPrestataire.setAttribute('name', 'prestataire');
                        selectPrestataire.required = true;

                        const optionNone = document.createElement('option');
                        optionNone.value = '';
                        optionNone.textContent = 'Aucun';
                        selectPrestataire.appendChild(optionNone);

                        prestataires.forEach(prestataire => {
                            const option = document.createElement('option');
                            option.value = prestataire.IDPrestataire;
                            option.textContent = prestataire.Domaine;
                            selectPrestataire.appendChild(option);
                        });

                        const divPrestataireSelect = document.getElementById('prestataire-select');
                        divPrestataireSelect.appendChild(selectPrestataire);
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de la récupération des données des prestataires');
                    });

                initMap(property.Adresse);

                document.getElementById('reserver').addEventListener('click', function () {
                    bookProperty(propertyId, property.Tarif, userId);
                });
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération des données du bien immobilier');
            });

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

        fetch('http://localhost/2A-ProjetAnnuel/PCS/API/user/id', {
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

                userId = data.user_id;
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération de l\'ID de l\'utilisateur');
            });

        function bookProperty(propertyId, propertyTarif, userId) {
            var checkin = document.getElementById('checkin').value;
            var checkout = document.getElementById('checkout').value;
            var guests = document.getElementById('guests').value;

            if (!checkin || !checkout || !guests) {
                alert('Veuillez remplir tous les champs du formulaire.');
                return;
            }


            var reservationDetails = {
                IDUtilisateur: userId,
                IDBien: propertyId,
                DateDebut: checkin,
                DateFin: checkout,
                Description: `Réservation de ${propertyId}`,
                Tarif: propertyTarif,
                Guests: guests,
                DomainePrestataire: document.getElementById('prestataire').value
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
                        console.error('Invalid JSON:', text);
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
<?php
require_once "../template/footer.php";
