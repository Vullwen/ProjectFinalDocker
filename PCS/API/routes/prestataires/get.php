<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "database/connectDB.php";

$pdo = connectDB();

try {
    $query = "SELECT IDPrestataire, Nom, Email, Telephone, Domaine FROM prestataire";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $prestataires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $prestataires]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des prestataires.']);
}