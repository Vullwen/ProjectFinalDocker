<?php

include_once '../../template/header.php';
include_once "../../../API/database/connectDB.php";

$db = connectDB();

$dbquery = $db->prepare("
    SELECT r.*, u.nom, u.email, u.telephone 
    FROM reservation r
    JOIN utilisateur u ON r.IDUtilisateur = u.IDUtilisateur
    WHERE r.IDBien = :IDBien
");
$dbquery->execute(['IDBien' => $_GET['id']]);
$reservations = $dbquery->fetchAll(PDO::FETCH_ASSOC);


$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE, 'Europe/Paris');
$formatter->setPattern('dd/MM/yyyy');

if (!empty($reservations)) {
    echo "<div class='container mt-5'>";
    echo "<h2 class='text-center mb-4'>Liste des réservations liées au bien</h2>";
    echo "<table class='table table-striped table-hover'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th scope='col'>Date de début</th>";
    echo "<th scope='col'>Date de fin</th>";
    echo "<th scope='col'>Nombre de voyageurs</th>";
    echo "<th scope='col'>Prix total</th>";
    echo "<th scope='col'>Client</th>";
    echo "<th scope='col'>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($reservations as $reservation) {

        $dateDebut = new DateTime($reservation['DateDebut']);
        $dateFin = new DateTime($reservation['DateFin']);
        $interval = $dateDebut->diff($dateFin);
        $nbJours = $interval->days;

        $prixTotal = $nbJours * $reservation['Tarif'];

        $dateDebutFormatted = $formatter->format($dateDebut);
        $dateFinFormatted = $formatter->format($dateFin);

        echo "<tr>";
        echo "<td class='align-middle'>{$dateDebutFormatted}</td>";
        echo "<td class='align-middle'>{$dateFinFormatted}</td>";
        echo "<td class='align-middle text-center'>{$reservation['NbVoyageurs']}</td>";
        echo "<td class='align-middle'>{$prixTotal} €</td>";
        echo "<td class='align-middle'>{$reservation['nom']}
                <button class='btn btn-info btn-sm ml-2' type='button' onclick='toggleCoordonnees({$reservation['IDReservation']})'>
                    Coordonnées
                </button>
                <div id='coordonnees-{$reservation['IDReservation']}' class='coordonnees' style='display:none;'>
                    <p>Email: {$reservation['email']}</p>
                    <p>Téléphone: {$reservation['telephone']}</
                </div>
                </td>";

        echo "<td class='align-middle'>
                <button onclick='handleAction(\"delete\", {$reservation['IDReservation']}, {$_GET['id']})' class='btn btn-danger btn-sm'>Supprimer</button>
                <button onclick='handleAction(\"accept\", {$reservation['IDReservation']}, {$_GET['id']})' class='btn btn-primary btn-sm'>Valider</button>
              </td>";

        echo "</tr>";

    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {

    echo "<div class='container mt-5'>";
    echo "<p>Aucune réservation n'a été trouvée pour ce bien.</p>";
    echo "</div>";
}
?>


<script>

    function toggleCoordonnees(id) {
        const coordonneesDiv = document.getElementById(`coordonnees-${id}`);
        if (coordonneesDiv.style.display === 'none') {
            coordonneesDiv.style.display = 'block';
        } else {
            coordonneesDiv.style.display = 'none';
        }
    }

    function handleAction(action, reservationId, idBien) {
        let endpoint = '';
        if (action === 'delete') {
            endpoint = `../../../API/routes/biens/delete_reservation.php`;
        } else if (action === 'accept') {
            endpoint = `../../../API/routes/biens/accept_reservation.php`;
        }

        console.log('ID Reservation:', reservationId);
        console.log('ID Bien:', idBien);
        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idReservation: reservationId,
                idBien: idBien
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log('Réponse JSON reçue:', data);
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


<?php
include_once '../../template/footer.php';