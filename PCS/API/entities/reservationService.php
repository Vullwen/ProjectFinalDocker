<?php
require_once __DIR__ . "/../database/connectDB.php";
$pdo = connectDB();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->IDUtilisateur) && isset($data->IDBien) && isset($data->DateDebut) && isset($data->DateFin)) {
    $userQuery = 'SELECT IDUtilisateur FROM utilisateur WHERE IDUtilisateur = ?';
    $userStmt = $pdo->prepare($userQuery);
    $userStmt->execute([$data->IDUtilisateur]);
    $userExists = $userStmt->fetch();

    $bienQuery = 'SELECT IDBien FROM bienimmobilier WHERE IDBien = ?';
    $bienStmt = $pdo->prepare($bienQuery);
    $bienStmt->execute([$data->IDBien]);
    $bienExists = $bienStmt->fetch();

    $serviceExists = true;
    if (isset($data->IDService)) {
        $serviceQuery = 'SELECT IDService FROM service WHERE IDService = ?';
        $serviceStmt = $pdo->prepare($serviceQuery);
        $serviceStmt->execute([$data->IDService]);
        $serviceExists = $serviceStmt->fetch();
    }

    if ($userExists && $bienExists && $serviceExists) {
        $query = 'INSERT INTO reservation (Description, Tarif, DateDebut, DateFin, IDUtilisateur, IDBien, IDService) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($query);
        $result = $stmt->execute([$data->Description, $data->Tarif, $data->DateDebut, $data->DateFin, $data->IDUtilisateur, $data->IDBien, $data->IDService ?? null]);

        if ($result) {
            echo json_encode(['message' => 'Booking successful']);
        } else {
            echo json_encode(['message' => 'Booking failed']);
        }
    } else {
        echo json_encode(['message' => 'User, property or service not found']);
    }
} else {
    echo json_encode(['message' => 'Invalid data']);
}
?>
