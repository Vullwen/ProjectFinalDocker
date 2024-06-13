<?php
require_once __DIR__ . "/../database/connectDB.php";

$conn = connectDB();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));
error_log(print_r($data, true)); // Log des données reçues

if (isset($data->IDUtilisateur) && isset($data->IDBien) && isset($data->DateDebut) && isset($data->DateFin) && isset($data->Description) && isset($data->Tarif)) {
    $userQuery = 'SELECT IDUtilisateur FROM utilisateur WHERE IDUtilisateur = ?';
    $userStmt = $conn->prepare($userQuery);
    $userStmt->execute([$data->IDUtilisateur]);
    $userExists = $userStmt->fetch();
    error_log('User exists: ' . print_r($userExists, true)); // Log de la vérification utilisateur

    $bienQuery = 'SELECT IDBien FROM bienimmobilier WHERE IDBien = ?';
    $bienStmt = $conn->prepare($bienQuery);
    $bienStmt->execute([$data->IDBien]);
    $bienExists = $bienStmt->fetch();
    error_log('Property exists: ' . print_r($bienExists, true)); // Log de la vérification du bien

    if ($userExists && $bienExists) {

        $query = 'INSERT INTO reservation (Description, Tarif, DateDebut, DateFin, IDUtilisateur, IDBien, NbVoyageurs, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$data->Description, $data->Tarif, $data->DateDebut, $data->DateFin, $data->IDUtilisateur, $data->IDBien, $data->Guests, 'Pending']);

        if ($result) {
            error_log('Booking successful'); // Log de la réussite de l'insertion
            echo json_encode(['message' => 'Booking successful']);
        } else {
            error_log('Booking failed'); // Log de l'échec de l'insertion
            echo json_encode(['message' => 'Booking failed']);
        }
    } else {
        error_log('User, property or service not found'); // Log de la non-existence de l'utilisateur ou du bien
        echo json_encode(['message' => 'User, property or service not found']);
    }
} else {
    error_log('Invalid data'); // Log de données invalides
    echo json_encode(['message' => 'Invalid data']);
}
?>