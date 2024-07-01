<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {
    $databaseConnection = connectDB();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $getPropertyQuery = $databaseConnection->prepare("SELECT * FROM bienimmobilier WHERE IDBien = :id");
        $getPropertyQuery->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $getPropertyQuery = $databaseConnection->prepare("SELECT * FROM bienimmobilier");
    }

    $getPropertyQuery->execute();
    $properties = $getPropertyQuery->fetchAll(PDO::FETCH_ASSOC);

    if (!$properties) {
        echo jsonResponse(404, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "Aucun bien immobilier trouvé."
        ]);
        exit;
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "properties" => $properties
    ]);


} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}