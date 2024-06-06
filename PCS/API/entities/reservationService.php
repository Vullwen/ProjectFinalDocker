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
<?php
require_once __DIR__ . "/../database/connectDB.php";
$conn = connectDB();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

error_log(print_r($data, true));

if (isset($data->IDUtilisateur) && isset($data->IDBien) && isset($data->DateDebut) && isset($data->DateFin) && isset($data->Description) && isset($data->Tarif)) {
    $userQuery = 'SELECT IDUtilisateur FROM utilisateur WHERE IDUtilisateur = ?';
    $userStmt = $conn->prepare($userQuery);
    $userStmt->execute([$data->IDUtilisateur]);
    $userExists = $userStmt->fetch();
    error_log('User exists: ' . print_r($userExists, true));

    $bienQuery = 'SELECT IDBien FROM bienimmobilier WHERE IDBien = ?';
    $bienStmt = $conn->prepare($bienQuery);
    $bienStmt->execute([$data->IDBien]);
    $bienExists = $bienStmt->fetch();
    error_log('Property exists: ' . print_r($bienExists, true));


    if ($userExists && $bienExists) {
        $query = 'INSERT INTO reservation (Description, Tarif, DateDebut, DateFin, IDUtilisateur, IDBien, NbVoyageurs, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$data->Description, $data->Tarif, $data->DateDebut, $data->DateFin, $data->IDUtilisateur, $data->IDBien ?? null, $data->Guests, 'Pending']);

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
