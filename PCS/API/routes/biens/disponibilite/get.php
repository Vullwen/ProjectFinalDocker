<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include __DIR__ . "/../../../libraries/parameters.php";
include __DIR__ . "/../../../libraries/body.php";
include __DIR__ . "/../../../libraries/response.php";
include __DIR__ . "/../../../database/connectDB.php";

try {
    $db = connectDB();

    $queryPrepared = $db->prepare("SELECT DateDebut, DateFin FROM disponibilite WHERE IDBien = :IDBien");
    $queryPrepared->execute(['IDBien' => $_GET['id']]);
    $disponibilites = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "disponibilites" => $disponibilites
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}