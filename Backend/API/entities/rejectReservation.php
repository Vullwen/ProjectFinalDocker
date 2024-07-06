<?php

header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    http_response_code(400);
    echo json_encode(['message' => 'ID de réservation manquant']);
    exit;
}

$id = $data->id;

try {

    $conn = connectDB();

    $query = "UPDATE reservation SET Status = 'Rejected' WHERE ID = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Réservation refusée avec succès']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erreur lors de la mise à jour de la réservation']);
    }
} catch (PDOException $exception) {
    http_response_code(500);
    echo json_encode(['message' => 'Erreur : ' . $exception->getMessage()]);
}
?>
