<?php
require_once "../../database/connectDB.php";

$conn = connectDB();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Lecture des données de la requête
$data = json_decode(file_get_contents("php://input"));

if (isset($data->idReservation)) {
    $query = 'DELETE FROM reservation WHERE IDReservation = ?';
    $stmt = $conn->prepare($query);
    $result = $stmt->execute([$data->idReservation]);

    if ($result) {
        echo json_encode(['message' => 'Reservation deleted']);
    } else {
        echo json_encode(['message' => 'Reservation deletion failed']);
    }
} else {
    echo json_encode(['message' => 'Invalid data']);
}
