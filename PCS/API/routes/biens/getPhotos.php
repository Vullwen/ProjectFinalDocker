<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {
    $db = connectDB();

    if (isset($_GET['idDemande'])) {
        $queryPrepared = $db->prepare("SELECT cheminPhoto FROM photobienimmobilier WHERE IDdemande = :id");
        $queryPrepared->bindParam(':id', $_GET['idDemande']);
    } elseif (isset($_GET['idBien'])) {
        $queryPrepared = $db->prepare("SELECT cheminPhoto FROM photobienimmobilier WHERE IDbien = :id");
        $queryPrepared->bindParam(':id', $_GET['idBien']);
    } else {
        echo jsonResponse(400, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "Paramètre IDmanquant."
        ]);
        exit;
    }

    $queryPrepared->execute();
    $photos = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

    if (!$photos) {
        echo jsonResponse(404, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "Aucune photo trouvée."
        ]);
        exit;
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "photos" => $photos
    ]);

} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}
