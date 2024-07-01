<?php
require_once __DIR__ . "/../database/connectDB.php";

$conn = connectDB();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));
error_log(print_r($data, true));

if (isset($data->IDUtilisateur) && isset($data->IDBien) && isset($data->DateDebut) && isset($data->DateFin) && isset($data->Description) && isset($data->Tarif) && isset($data->Guests)) {

    $query = 'INSERT INTO reservation (Description, Tarif, DateDebut, DateFin, IDUtilisateur, IDBien, NbVoyageurs, Prestations, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($query);
    $result = $stmt->execute([$data->Description, $data->Tarif, $data->DateDebut, $data->DateFin, $data->IDUtilisateur, $data->IDBien, $data->Guests, $data->DomainePrestataire, 'Pending']);

    if ($result) {
        error_log('Booking successful');
        echo json_encode(['message' => 'Booking successful']);
    } else {
        error_log('Booking failed');
        echo json_encode(['message' => 'Booking failed']);
    }
} else {
    error_log('Invalid data');
    echo json_encode(['message' => 'Invalid data']);
}
