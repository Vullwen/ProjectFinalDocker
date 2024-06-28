<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adapter selon votre configuration CORS
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../database/connectDB.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = $data['id'];

    $conn = connectDB();
    $query = 'DELETE FROM bienimmobilier WHERE IDBien = ?';
    $stmt = $conn->prepare($query);
    $result = $stmt->execute([$id]);

    if ($result) {
        http_response_code(200);
        echo json_encode(['message' => 'Bien immobilier supprimé avec succès']);
        exit;
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Échec de la suppression du bien immobilier']);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'ID du bien à supprimer non spécifié']);
    exit;
}
