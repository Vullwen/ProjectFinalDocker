<?php

include_once "../../template/header.php";
include_once "../../../API/database/connectDB.php";

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<?php

$db = connectDB();

$dbquery = $db->prepare("SELECT * FROM bienimmobilier WHERE IDBien = :IDBien");
$dbquery->execute(['IDBien' => $_GET['id']]);
$bien = $dbquery->fetch(PDO::FETCH_ASSOC);

$photosQuery = $db->prepare("SELECT cheminPhoto FROM photobienimmobilier WHERE IDBien = :IDBien");
$photosQuery->execute(['IDBien' => $_GET['id']]);
$photos = $photosQuery->fetchAll(PDO::FETCH_ASSOC);

if ($bien) {
    echo "<div class='container mt-5'>";
    echo "<h2>Détails du Bien Immobilier</h2>";
    echo "<p><strong>Type:</strong> {$bien['Type_bien']}</p>";
    echo "<p><strong>Adresse:</strong> {$bien['Adresse']}</p>";
    echo '<div class="location">';
    echo '<h2>Localisation</h2>';
    echo '<div id="map" style="height: 300px;"></div>';
    echo '</div>';
    echo "<p><strong>Description:</strong> {$bien['Description']}</p>";
    echo "<p><strong>Superficie:</strong> {$bien['Superficie']}</p>";
    echo "<p><strong>Nombre de Chambres:</strong> {$bien['NbChambres']}</p>";
    echo "<p><strong>Tarif:</strong> {$bien['Tarif']} € / nuit</p>";

    // Afficher les photos du bien
    if (!empty($photos)) {
        echo "<h3>Photos</h3>";
        echo "<div class='row'>";
        foreach ($photos as $photo) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<img src='https://localhost/2A-ProjetAnnuel/PCS/Site/img/photosBI/{$photo['cheminPhoto']}' class='img-fluid' alt='Photo'>";
            echo "</div>";
        }
        echo "</div>";

    }

    echo "</div>";

    echo "<a href='modifierBiens.php?id={$bien['IDBien']}' class='btn btn-primary'>Modifier</a>";
    echo "<button onclick='deleteBien({$bien['IDBien']})' class='btn btn-danger'>Supprimer</button>";

    echo "<a href='biensListe.php' class='btn btn-secondary'>Retour à la liste</a>";
    echo "<a href='details_reservation.php?id={$bien['IDBien']}' class='btn btn-primary'>Voir les réservations</a>";

} else {
    echo "<div class='container mt-5'>";
    echo "<p>Le bien immobilier demandé n'existe pas.</p>";
    echo "</div>";
}
?>
<script>

    function deleteBien(idBien) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce bien ?")) {
            fetch(`../../../API/routes/biens/delete.php?id=${idBien}`, {
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
    const urlParams = new URLSearchParams(window.location.search);
    const propertyId = urlParams.get('id');
    const bien = <?php echo json_encode($bien); ?>;

    initMap(bien.Adresse);

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
</script>

<?php
include "../../template/footer.php";