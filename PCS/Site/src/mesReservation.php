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

if ($user) {
    $IDUtilisateur = $user['IDUtilisateur'];

    $query = $conn->prepare("SELECT r.IDReservation, r.DateDebut, r.DateFin, b.Adresse AS NomBien, r.isPaid, b.Tarif
                             FROM reservation r 
                             JOIN bienimmobilier b ON r.IDBien = b.IDBien 
                             WHERE r.IDUtilisateur = :IDUtilisateur AND r.Status = 'Accepted'");
    $query->execute(['IDUtilisateur' => $IDUtilisateur]);
    $reservations = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($reservations)) {
        echo "<div class='container mt-5'>";
        echo "<h2>Mes Réservations</h2>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Date de Début</th>";
        echo "<th scope='col'>Date de Fin</th>";
        echo "<th scope='col'>Bien</th>";
        echo "<th scope='col'>Prix Total</th>";
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

            echo "<tr>";
            echo "<td>" . htmlspecialchars($reservation['DateDebut']) . "</td>";
            echo "<td>" . htmlspecialchars($reservation['DateFin']) . "</td>";
            echo "<td>" . htmlspecialchars($reservation['NomBien']) . "</td>";
            echo "<td>" . htmlspecialchars($prixTotal) . " €</td>";
            echo "<td>";
            if (!$reservation['isPaid']) {
                echo "<button class='btn btn-primary' onclick='redirectToPayment({$reservation['IDReservation']}, {$prixTotal})'>Payer</button>";
            } else {
                echo "Payé";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'>";
        echo "<p>Aucune réservation trouvée.</p>";
        echo "</div>";
    }
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Une erreur s'est produite lors de la récupération de vos réservations.</p>";
    echo "</div>";
}

include_once '../template/footer.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <h1>Mes Réservations</h1>
</div>

<script>
    function redirectToPayment(reservationId, prixTotal) {
        window.location.href = `paiement.php?reservationId=${reservationId}&prixTotal=${prixTotal}`;
    }
</script>
</body>
</html>
