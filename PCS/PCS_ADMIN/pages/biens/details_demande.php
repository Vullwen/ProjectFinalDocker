<?php
include_once '../../../Site/template/header.php';
include_once '../../../API/database/connectDB.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("L'identifiant de la demande est obligatoire.");
} else if (!isset($_SESSION['isAdmin'])) {
    die("Vous n'êtes pas autorisé à accéder à cette page.");
} else {
    $databaseConnection = connectDB();

    if (!$databaseConnection) {
        die("La connexion à la base de données a échoué.");
    }


    $getDemandesQuery = $databaseConnection->query("SELECT id, type_conciergerie, autre_conciergerie, adresse, pays, superficie, type_bien, type_location, nombre_chambres, capacite, nom, telephone, email, heure_contact, etat FROM demandebailleurs WHERE id = " . $_GET['id'] . "");



    if ($getDemandesQuery->rowCount() > 0) {
        ?>
            <div class="container mt-5">
                <h2>Demandes des bailleurs</h2>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Numéro de demande</th>
                            <th scope="col">Type de conciergerie</th>
                            <th scope="col">Autre conciergerie</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Pays</th>
                            <th scope="col">Type de bien</th>
                            <th scope="col">Type de location</th>
                            <th scope="col">Superficie</th>
                            <th scope="col">Nombre de chambres</th>
                            <th scope="col">Capacité</th>
                            <th scope="col">Nom du propriétaire</th>
                            <th scope="col">Télephone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Heure de contact</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($demande = $getDemandesQuery->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <tr>
                                <th scope="row"><?php echo htmlspecialchars($demande['id']); ?></th>
                                <td><?php echo htmlspecialchars($demande['type_conciergerie']); ?></td>
                                <td><?php echo htmlspecialchars($demande['autre_conciergerie']); ?></td>
                                <td>
                                    <span class="address"
                                        onclick="showMap('<?php echo htmlspecialchars(addslashes($demande['adresse'] . ', ' . $demande['pays'])); ?>')">
                                    <?php echo htmlspecialchars($demande['adresse']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($demande['pays']); ?></td>
                                <td><?php echo htmlspecialchars($demande['type_bien']); ?></td>
                                <td><?php echo htmlspecialchars($demande['type_location']); ?></td>
                                <td><?php echo htmlspecialchars($demande['superficie']); ?></td>
                                <td><?php echo htmlspecialchars($demande['nombre_chambres']); ?></td>
                                <td><?php echo htmlspecialchars($demande['capacite']); ?></td>
                                <td><?php echo htmlspecialchars($demande['nom']); ?></td>
                                <td><?php echo htmlspecialchars($demande['telephone']); ?></td>
                                <td>
                                <?
                                echo htmlspecialchars($demande['email']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($demande['heure_contact']); ?></td>
                                <td><?php echo htmlspecialchars($demande['etat']); ?></td>

                                <td><a class='btn btn-info btn-sm ml-2'
                                        href="accept_demande.php?id=<?php echo htmlspecialchars($demande['id']); ?>">Accepter la
                                        demande</a>
                                    <a class='btn btn-info btn-sm ml-2 btn-red'
                                        href="refuse_demande.php?id=<?php echo htmlspecialchars($demande['id']); ?>">Refuser la
                                        demande</a>
                                </td>
                            </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" onclick="window.history.back()">Retour</button>
            <div class="overlay" id="map-overlay" onclick="hideMap()"></div>
            <div class="map-widget" id="map-widget">
                <div class="close" onclick="hideMap()">×</div>
                <div id="map"></div>
            </div>
        <?php
    } else {
        echo "<div class='container mt-5'><p>Aucune demande de bailleur n'a été trouvée.</p></div>";
    }
}
?>
<script>
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

    document.addEventListener('DOMContentLoaded', initMap);


</script>