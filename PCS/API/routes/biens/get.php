<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {
    $databaseConnection = connectDB();

    if (!$databaseConnection) {
        echo jsonResponse(500, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "La connexion à la base de données a échoué."
        ]);
        exit;
    }

    if (!isset($_GET['id'])) {
        echo jsonResponse(400, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "L'ID du bien immobilier est requis."
        ]);
        exit;
    }

    $id = $_GET['id'];

    $getPropertyQuery = $databaseConnection->prepare("SELECT * FROM bienimmobilier WHERE IDBien = :id");
    $getPropertyQuery->bindParam(':id', $id, PDO::PARAM_INT);
    $getPropertyQuery->execute();
    $property = $getPropertyQuery->fetch(PDO::FETCH_ASSOC);

    if (!$property) {
        echo jsonResponse(404, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "Bien immobilier non trouvé."
        ]);
        exit;
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "property" => $property
    ]);

} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}