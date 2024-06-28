<?php
include __DIR__ . "/../../database/connectDB.php";
include __DIR__ . "/../../libraries/response.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

try {

    $dbconnect = connectDB();

    $queryPrepared = $dbconnect->prepare("SELECT * FROM reservation WHERE IDBien = :IDBien");

    $queryPrepared->execute(['IDBien' => $_GET['id']]);

    $reservations = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "reservations" => $reservations
    ]);

} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}
