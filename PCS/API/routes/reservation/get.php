<?php

include "database/connectDB.php";

$pdo = connectDB();

try {
    $query = "
        SELECT r.IDReservation, r.DateDebut, r.DateFin, r.Status, p.IDBien, r.IDBien, p.adresse
        FROM reservation r
        JOIN bienimmobilier p ON r.IDBien = p.IDBien
        WHERE r.IDUtilisateur = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $reservations]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des réservations.']);

}
