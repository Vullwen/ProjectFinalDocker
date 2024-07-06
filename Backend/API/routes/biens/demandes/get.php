<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include __DIR__ . "/../../../libraries/parameters.php";
include __DIR__ . "/../../../libraries/body.php";
include __DIR__ . "/../../../libraries/response.php";
include __DIR__ . "/../../../database/connectDB.php";

try {
    $pdo = connectDB();
    $query = "SELECT * FROM demandebailleurs";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des demandes de bailleurs.']);
    exit();
}

if ($stmt->rowCount() === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Aucune demande de bailleur trouvée.']);
    exit();
} else {
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $demandes]);
    exit();
}