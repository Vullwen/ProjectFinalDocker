<?php
include_once "../../template/header.php";
$idBien = $_GET['id'];
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<div class="container mt-5"></div>

<script>
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let fetchedReservations = [];
    document.addEventListener("DOMContentLoaded", function () {

        const bienId = new URLSearchParams(window.location.search).get('id');

        fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens?id=${bienId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de la récupération des détails du bien');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const bien = data.properties[0];
                    displayBienDetails(bien);
                    fetchDisponibilites(bienId);
                    fetchReservations(bienId);
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la récupération des détails du bien.');
            });



        function displayBienDetails(bien) {
            const container = document.querySelector('.container.mt-5');
            container.innerHTML = `
        <h2>Détails du Bien Immobilier</h2>
        <p><strong>Type:</strong> ${bien.Type_bien}</p>
        <p><strong>Adresse:</strong> ${bien.Adresse}</p>
        <div class="location">
            <h2>Localisation</h2>
            <div id="map"></div>
        </div>
        <p><strong>Description:</strong> ${bien.Description}</p>
        <p><strong>Superficie:</strong> ${bien.Superficie}</p>
        <p><strong>Nombre de Chambres:</strong> ${bien.NbChambres}</p>
        <p><strong>Tarif:</strong> ${bien.Tarif} € / nuit</p>
        <a href="modifierBiens.php?id=${bien.IDBien}" class="btn btn-primary">Modifier</a>
        <a href="modifierPhotos.php?id=${bien.IDBien}" class="btn btn-primary">Modifier les photos</a>
        <button onclick="deleteBien(${bien.IDBien})" class="btn btn-danger">Supprimer</button>
        <a href="biensListe.php" class="btn btn-secondary">Retour à la liste</a>
        <a href="details_reservation.php?id=${bien.IDBien}" class="btn btn-primary">Voir les réservations</a>
            <h2>Calendrier des disponibilités</h2>
    <div class="calendar-container">
    <table class="calendar">
        <thead>
            <tr>
                <th id="prev-month-btn">&lt;</th>
                <th colspan="5" id="month-year"></th>
                <th id="next-month-btn">&gt;</th>
            <tr>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mer</th>
                <th>Jeu</th>
                <th>Ven</th>
                <th>Sam</th>
                <th>Dim</th>
            </tr>
        </thead>
        <tbody id="calendar-body">
        </tbody>
    </table>
                <div class="legend">
                <p><span class="legend unavailable"></span> Réservé</p>
                <p><span class="legend pending"></span> En attente</p>
            </div>
        </div>
    `;
            initMap(bien.Adresse);
        }


        function fetchDisponibilites(idBien) {
            fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/disponibilite?id=${idBien}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la récupération des disponibilités');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const disponibilites = data.disponibilites;
                        const startDate = new Date(disponibilites[0].DateDebut);
                        const endDate = new Date(disponibilites[0].DateFin);
                        displayDisponibilites(startDate, endDate);
                    } else {
                        console.error('Erreur:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la récupération des disponibilités.');
                });
        }

        function displayDisponibilites(startDate, endDate) {
            const calendarBody = document.getElementById('calendar-body');
            if (!calendarBody) {
                console.error("Erreur: L'élément avec l'ID 'calendar-body' n'a pas été trouvé.");
                return;
            }

            if (startDate && endDate) {
                generateCalendar(currentYear, currentMonth, startDate, endDate);
                displayMonthAndYear(currentYear, currentMonth);
            } else {
                console.error("Erreur: Les dates de disponibilité ne sont pas valides.");
            }

            document.getElementById('prev-month-btn').addEventListener('click', function () {
                displayPreviousMonth(startDate, endDate);
            });

            document.getElementById('next-month-btn').addEventListener('click', function () {
                displayNextMonth(startDate, endDate);
            });
        }

        function generateCalendar(year, month, startDate, endDate) {
            const calendarBody = document.getElementById('calendar-body');
            calendarBody.innerHTML = '';

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            let date = 1;
            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');
                for (let j = 1; j <= 7; j++) {
                    if (i === 0 && j < firstDay) {
                        const cell = document.createElement('td');
                        row.appendChild(cell);
                    } else if (date > daysInMonth) {
                        break;
                    } else {
                        const cell = document.createElement('td');
                        cell.textContent = date;
                        row.appendChild(cell);

                        const currentDate = new Date(year, month, date);
                        if (currentDate >= startDate && currentDate <= endDate) {
                            const today = new Date();
                            if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                                cell.classList.add('today');
                            }
                        } else {
                            cell.classList.add('disabled');
                            cell.style.visibility = 'hidden';
                        }

                        date++;
                    }
                }
                calendarBody.appendChild(row);
                if (date > daysInMonth) break;
            }
            fetchedReservations.forEach(reservation => {
                const startReservation = new Date(reservation.DateDebut);
                const endReservation = new Date(reservation.DateFin);
                markDatesUnavailable(startReservation, endReservation, reservation.Status, year, month);
            });
        }

        function displayMonthAndYear(year, month) {
            const monthYearHeader = document.getElementById('month-year');
            if (monthYearHeader) {
                const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                monthYearHeader.textContent = monthNames[month] + ' ' + year;
            }
        }

        function displayPreviousMonth(startDate, endDate) {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentYear, currentMonth, startDate, endDate);
            displayMonthAndYear(currentYear, currentMonth);
        }

        function displayNextMonth(startDate, endDate) {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentYear, currentMonth, startDate, endDate);
            displayMonthAndYear(currentYear, currentMonth);
        }


        function deleteBien(idBien) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce bien ?")) {
                fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/biens/delete.php?id=${idBien}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: idBien })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur lors de la suppression du bien');
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la suppression du bien.');
                    });
            }
        }

        function initMap(address) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: address }, function (results, status) {
                if (status === 'OK') {
                    const location = results[0].geometry.location;
                    const map = new google.maps.Map(document.getElementById('map'), {
                        center: location,
                        zoom: 15
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

        function fetchReservations(idBien) {
            fetch(`http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/reservationsCalendar?id=${idBien}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la récupération des réservations');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const reservations = data.reservations;
                        fetchedReservations = data.reservations;
                        fetchedReservations.forEach(reservation => {
                            const startReservation = new Date(reservation.DateDebut);
                            const endReservation = new Date(reservation.DateFin);
                            markDatesUnavailable(startReservation, endReservation, reservation.Status, currentYear, currentMonth);
                        });
                    } else {
                        console.error('Erreur:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la récupération des réservations.');
                });
        }

        function markDatesUnavailable(startDateStr, endDateStr, status, year, month) {
            const startDate = new Date(startDateStr);
            startDate.setHours(0, 0, 0, 0);

            const endDate = new Date(endDateStr);
            endDate.setHours(0, 0, 0, 0);

            const calendarCells = document.querySelectorAll('#calendar-body td');
            calendarCells.forEach(cell => {
                const dayOfMonth = parseInt(cell.textContent);
                if (!isNaN(dayOfMonth)) {
                    const cellDate = new Date(year, month, dayOfMonth);
                    if (cellDate.getTime() >= startDate.getTime() && cellDate.getTime() <= endDate.getTime()) {
                        if (status === 'Accepted') {
                            cell.classList.add('unavailable');
                        } else if (status === 'Pending') {
                            cell.classList.add('pending');
                        }
                    }
                }
            });
        }



    });
</script>
<?php
include "../../template/footer.php";
?>