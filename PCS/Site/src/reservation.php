<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Bien Immobilier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../../styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD08lqylUbFmtiXYQJVlRsiDojk3AvzXO8"></script>
</head>

<body>
    <div class="container mt-5" id="property-container">
        <!-- Le contenu sera inséré ici par JavaScript -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const propertyId = urlParams.get('id');

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
            displayProperty(property);
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la récupération des données');
        });

    function displayProperty(property) {
        const container = document.getElementById('property-container');

        container.innerHTML = `
            <div class="property">
                <h1>${property.Type} - ${property.Adresse}</h1>
                <p>${property.Description.replace(/\n/g, '<br>')}</p>
                <div class="additional-info">
                    <h2>Équipements disponibles</h2>
                    <ul>
                        <!-- Ajoutez ici les équipements si vous les avez dans la base de données -->
                    </ul>
                    <h2>Règles de la maison</h2>
                    <ul>
                        <!-- Ajoutez ici les règles si vous les avez dans la base de données -->
                    </ul>
                    <h2>Tarifs et frais supplémentaires</h2>
                    <p>Tarif par nuit : ${property.Tarif}€</p>
                </div>
                <div class="location">
                    <h2>Localisation</h2>
                    <div id="map" style="height: 300px;"></div>
                    <p>Proximité des transports en commun, attractions touristiques, restaurants, etc.</p>
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
                        <button type="submit" class="btn btn-primary">Réserver</button>
                    </form>
                </div>
            </div>
        `;

        // Géocoder l'adresse postale pour obtenir les coordonnées géographiques
        geocodeAddress(property.Adresse);
    }

    function geocodeAddress(address) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status === 'OK') {
                const location = results[0].geometry.location;
                const map = L.map('map').setView([location.lat(), location.lng()], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);
                L.marker([location.lat(), location.lng()]).addTo(map)
                    .bindPopup(address)
                    .openPopup();
            } else {
                document.getElementById('map').innerText = 'Localisation non disponible : ' + status;
            }
        });
    }
});

    </script>
</body>

</html>
