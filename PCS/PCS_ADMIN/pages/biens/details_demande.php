<?php
include_once '../../../Site/template/header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("L'identifiant de la demande est obligatoire.");
} else if (!isset($_SESSION['isAdmin'])) {
    die("Vous n'êtes pas autorisé à accéder à cette page.");
}

$apiUrl = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/demandebiens?id=' . $_GET['id'];

$response = file_get_contents($apiUrl);


if ($response === FALSE) {
    die("L'appel à l'API a échoué.");
}

$responseData = json_decode($response, true);

if (!$responseData || !$responseData['success']) {
    die("Aucune demande de bailleur n'a été trouvée ou une erreur s'est produite.");
}

$demande = $responseData['data'];
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Demande de bailleur - Numéro <?php echo htmlspecialchars($demande['id']); ?></h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Type de conciergerie :</h5>
                    <p><?php echo htmlspecialchars($demande['type_conciergerie']); ?></p>
                    <h5>Autre conciergerie :</h5>
                    <p><?php echo htmlspecialchars($demande['autre_conciergerie']); ?></p>
                    <h5>Adresse :</h5>
                    <p>
                        <span class="address"
                            onclick="showMap('<?php echo htmlspecialchars(addslashes($demande['adresse'] . ', ' . $demande['pays'])); ?>')">
                            <?php echo htmlspecialchars($demande['adresse']); ?>
                        </span>
                    </p>
                    <h5>Pays :</h5>
                    <p><?php echo htmlspecialchars($demande['pays']); ?></p>
                    <h5>Type de bien :</h5>
                    <p><?php echo htmlspecialchars($demande['type_bien']); ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Type de location :</h5>
                    <p><?php echo htmlspecialchars($demande['type_location']); ?></p>
                    <h5>Superficie :</h5>
                    <p><?php echo htmlspecialchars($demande['superficie']); ?></p>
                    <h5>Nombre de chambres :</h5>
                    <p><?php echo htmlspecialchars($demande['nombre_chambres']); ?></p>
                    <h5>Capacité :</h5>
                    <p><?php echo htmlspecialchars($demande['capacite']); ?></p>
                    <h5>Nom du propriétaire :</h5>
                    <p><?php echo htmlspecialchars($demande['nom']); ?></p>
                    <h5>Téléphone :</h5>
                    <p><?php echo htmlspecialchars($demande['telephone']); ?></p>
                    <h5>Email :</h5>
                    <p><?php echo htmlspecialchars($demande['email']); ?></p>
                    <h5>Heure de contact :</h5>
                    <p><?php echo htmlspecialchars($demande['heure_contact']); ?></p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <h5>État :</h5>
                    <p><?php echo htmlspecialchars($demande['etat']); ?></p>
                </div>
            </div>
            <div>
                <label for="tarif">Tarif à la nuit :</label>
                <input type="number" id="tarif" name="tarif">
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <h5>Photos :</h5>
                    <div id="photo-container"></div>
                </div>
            </div>
            <div id="image-overlay" onclick="hideImage()">
                <img id="overlay-img" src="" alt="Agrandissement de l'image">
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <h5>Actions :</h5>
                    <button class='btn btn-info btn-sm ml-2'
                        onclick="acceptDemande(<?php echo htmlspecialchars($demande['id']); ?>)">Accepter la
                        demande</button>
                    <a class='btn btn-info btn-sm ml-2 btn-red'
                        href="refuse_demande.php?id=<?php echo htmlspecialchars($demande['id']); ?>">Refuser la
                        demande</a>
                </div>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-primary" onclick="window.history.back()">Retour</button>
<div class="overlay" id="map-overlay" onclick="hideMap()"></div>
<div class="map-widget" id="map-widget">
    <div class="close" onclick="hideMap()">×</div>
    <div id="map"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photosUrl = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/demandesBiens/photos?id=<?php echo $_GET['id']; ?>';

        fetch(photosUrl)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.photos.length > 0) {
                    const photoContainer = document.getElementById('photo-container');

                    data.photos.forEach(photo => {
                        const imgElement = document.createElement('img');
                        imgElement.src = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/Site/' + photo.cheminPhoto;
                        imgElement.alt = 'Photo de bien immobilier';
                        imgElement.classList.add('img-thumbnail', 'mr-2', 'mb-2');

                        imgElement.addEventListener('click', function () {
                            showImage(imgElement.src);
                        });

                        photoContainer.appendChild(imgElement);
                    });
                }
            })
            .catch(error => console.error('Erreur lors du chargement des photos :', error));
    });

    function showImage(src) {
        const overlay = document.getElementById('image-overlay');
        const overlayImg = document.getElementById('overlay-img');
        overlayImg.src = src;
        overlay.style.display = 'flex';
    }

    function hideImage() {
        const overlay = document.getElementById('image-overlay');
        overlay.style.display = 'none';
    }

    function initMap() {
        window.map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
        });
    }

    function showMap(address) {
        const overlay = document.getElementById('map-overlay');
        const mapWidget = document.getElementById('map-widget');

        overlay.style.display = 'block';
        mapWidget.style.display = 'block';

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status === 'OK') {
                window.map.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: window.map,
                    position: results[0].geometry.location
                });
            } else {
                document.getElementById('map').innerHTML = 'Adresse introuvable';
            }
        });
    }

    function hideMap() {
        document.getElementById('map-overlay').style.display = 'none';
        document.getElementById('map-widget').style.display = 'none';
    }

    function acceptDemande(id) {
        const tarif = document.getElementById('tarif').value;
        if (!tarif) {
            alert('Veuillez entrer un tarif à la nuit.');
            return;
        }

        const data = {
            id: id,
            tarif: tarif,
        };

        fetch('http://localhost/2A-ProjetAnnuel/PCS/API/biens', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('La demande a été acceptée avec succès.');
                    window.location.href = 'demandeBailleurs.php';
                } else {
                    alert('Une erreur s\'est produite lors de l\'acceptation de la demande.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la demande d\'acceptation :', error);
                alert('Erreur lors de la demande d\'acceptation.');
            });
    }

    document.addEventListener('DOMContentLoaded', initMap);
</script>

<?php
include_once '../../../Site/template/footer.php';