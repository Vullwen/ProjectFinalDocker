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
                    <label for="guests" class="form-label">Nombre de personnes</label>
                    <input type="number" class="form-control" id="guests" required>
                </div>
                <div id="calendar"></div>
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
        const urlParams = new URLSearchParams(window.location.search);
        const propertyId = urlParams.get('id');
        let reservations = [];
        let selectedDates = { start: null, end: null };
        let userId;
        let isSelectingStart = true;

        if (!propertyId) {
            alert('ID du bien immobilier manquant dans l\'URL');
            return;
        }

        fetch(`../../API/routes/biens/get.php?id=${propertyId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Erreur lors de la récupération des données');
                    return;
                }

                const property = data.property;
                document.getElementById('property-title').textContent = `${property.Type_bien} - ${property.Adresse}`;
                document.getElementById('property-description').innerHTML = property.Description.replace(/\n/g, '<br>');
                document.getElementById('property-tarif').textContent = `Tarif par nuit : ${property.Tarif}€`;

                fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/reservationsCalendar?id=${propertyId}`)
                    .then(response => response.json())
                    .then(resData => {
                        if (resData.success) {
                            reservations = resData.reservations.map(res => {

                                return {
                                    title: res.Status === 'Pending' ? 'En attente' : 'Réservé',
                                    start: new Date(res.DateDebut).toISOString().slice(0, 10),
                                    end: new Date(new Date(res.DateFin).getTime() + 24 * 60 * 60 * 1000).toISOString().slice(0, 10),
                                    color: res.Status === 'Pending' ? 'orange' : 'red',
                                    rendering: 'background'
                                };
                            });
                            initializeCalendar();
                        } else {
                            alert('Erreur lors de la récupération des réservations');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de la récupération des réservations');
                    });

                fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/prestataires`)
                    .then(response => response.json())
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

        function initializeCalendar() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: reservations,
                select: function (info) {
                    if (isSelectingStart) {
                        selectedDates.start = info.startStr;
                        selectedDates.end = null;
                        isSelectingStart = false;
                    } else {
                        selectedDates.end = info.endStr;
                        isSelectingStart = true;
                        calendar.unselect();
                    }
                    updateSelection();
                },
                eventOverlap: false,
                eventConstraint: {
                    start: '00:00',
                    end: '24:00',
                    daysOfWeek: [0, 1, 2, 3, 4, 5, 6]
                },
                eventAllow: function (dropInfo, draggedEvent) {
                    return !reservations.some(event => {
                        return (
                            (dropInfo.start >= new Date(event.start) && dropInfo.start < new Date(event.end)) ||
                            (dropInfo.end > new Date(event.start) && dropInfo.end <= new Date(event.end))
                        );
                    });
                },
                selectAllow: function (selectInfo) {
                    return !reservations.some(event => {
                        return (
                            (selectInfo.start >= new Date(event.start) && selectInfo.start < new Date(event.end)) ||
                            (selectInfo.end > new Date(event.start) && selectInfo.end <= new Date(event.end))
                        );
                    });
                }
            });
            calendar.render();
        }

        function updateSelection() {
            if (selectedDates.start && selectedDates.end) {
                alert(`Dates sélectionnées : du ${selectedDates.start} au ${selectedDates.end}`);
            } else if (selectedDates.start) {
                alert(`Date d'arrivée sélectionnée : ${selectedDates.start}`);
            }
        }

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id', {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + <?php echo json_encode($_SESSION['token']); ?> }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    userId = data.user_id;
                } else {
                    alert('Erreur lors de la récupération de l\'ID de l\'utilisateur');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération de l\'ID de l\'utilisateur');
            });

        function bookProperty(propertyId, propertyTarif, userId) {
            if (!selectedDates.start || !selectedDates.end) {
                alert('Veuillez sélectionner des dates dans le calendrier.');
                return;
            }

            var guests = document.getElementById('guests').value;

            if (!guests) {
                alert('Veuillez remplir le nombre de personnes.');
                return;
            }

            var reservationDetails = {
                IDUtilisateur: userId,
                IDBien: propertyId,
                DateDebut: selectedDates.start,
                DateFin: selectedDates.end,
                Description: `Réservation de ${propertyId}`,
                Tarif: propertyTarif,
                Guests: guests,
                DomainePrestataire: document.getElementById('prestataire').value
            };

            fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/entities/reservationService.php', {
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
                        calendar.addEvent({
                            title: 'En attente',
                            start: selectedDates.start,
                            end: selectedDates.end,
                            color: 'orange'
                        });
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
