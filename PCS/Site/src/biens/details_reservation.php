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
                    <p>Téléphone: {$reservation['telephone']}</p>
                </div>
              </td>";
        echo "<td class='align-middle'><a href='/2A-ProjetAnnuel/PCS/Site/src/reservations/details_reservation.php?id={$reservation['IDReservation']}' class='btn btn-primary'>Gérer</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Aucune réservation n'a été effectuée pour ce bien.</p>";
    echo "</div>";
}

include_once '../../template/footer.php';
?>

<script>
    function toggleCoordonnees(id) {
        var element = document.getElementById('coordonnees-' + id);
        if (element.style.display === 'none') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    }
</script>