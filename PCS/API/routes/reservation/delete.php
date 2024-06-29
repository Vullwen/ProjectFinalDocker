<?php
include "database/connectDB.php";

$pdo = connectDB();

try {
    $queryPrepared = "DELETE FROM reservation WHERE IDReservation = ?";
    $stmt = $pdo->prepare($queryPrepared);
    $stmt->execute([$_GET['id']]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $reservations]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);

}
