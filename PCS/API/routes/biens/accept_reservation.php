<?php
require_once "../../database/connectDB.php";

$conn = connectDB();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->idReservation)) {
    $query = 'UPDATE reservation SET Status = ? WHERE IDReservation = ?';
    $stmt = $conn->prepare($query);
    $result = $stmt->execute(['Accepted', $data->idReservation]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Reservation accepted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Reservation update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
}
