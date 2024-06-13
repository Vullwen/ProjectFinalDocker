<?php
require_once '../../database/connectDB.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$reservationId = $data['reservationId'];
$conn = connectDB();
$query = $conn->prepare("
    SELECT r.*, b.Tarif AS BienTarif, DATEDIFF(r.DateFin, r.DateDebut) AS NbJours
    FROM reservation r
    JOIN bienimmobilier b ON r.IDBien = b.IDBien
    WHERE r.IDReservation = :reservationId
");
$query->execute(['reservationId' => $reservationId]);
$reservation = $query->fetch(PDO::FETCH_ASSOC);
if ($reservation) {

    $prixTotal = $reservation['BienTarif'] * $reservation['NbJours'];
    $reservation['PrixTotal'] = $prixTotal;
    
    echo json_encode(['success' => true, 'reservation' => $reservation]);
} else {
    echo json_encode(['success' => false, 'message' => 'Réservation non trouvée.']);
}