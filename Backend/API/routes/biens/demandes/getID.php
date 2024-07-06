<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include __DIR__ . "/../../../libraries/parameters.php";
include __DIR__ . "/../../../libraries/body.php";
include __DIR__ . "/../../../libraries/response.php";
include __DIR__ . "/../../../database/connectDB.php";

try {
    $connectDB = connectDB();
    $queryPrepared = $connectDB->prepare("SELECT * FROM demandebailleurs WHERE id = :id");
    $queryPrepared->execute(['id' => $_GET['id']]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération de la demande de bailleur.']);
    exit();
}

if ($queryPrepared->rowCount() === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Aucune demande de bailleur trouvée.']);
    exit();
} else {
    $demande = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $demande]);
    exit();
}
