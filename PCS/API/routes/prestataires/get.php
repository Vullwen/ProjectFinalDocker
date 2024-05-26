<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../database/connectDB.php";

$pdo = connectDB();

try {
    $query = "SELECT * FROM demandes_prestataires";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $demandes]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des demandes de prestataires.']);
}
?>
