<?php

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";


try {
    $body = getBody();

    // Verification des champs

    if (!isset($body['adresse']) || empty($body['adresse'])) {
        throw new Exception("L'adresse est obligatoire.");
    }

    if (!isset($body['type']) || empty($body['type'])) {
        throw new Exception("Le type est obligatoire.");
    }

    if (!isset($body['description']) || empty($body['description'])) {
        throw new Exception("La description est obligatoire.");
    }

    if (!isset($body['superficie']) || empty($body['superficie'])) {
        throw new Exception("La superficie est obligatoire.");
    }

    if (!isset($body['nbchambres']) || empty($body['nbchambres'])) {
        throw new Exception("Le nombre de chambres est obligatoire.");
    }

    if (!isset($body['tarif']) || empty($body['tarif'])) {
        throw new Exception("Le tarif est obligatoire.");
    }

    if (!isset($body['idutilisateur']) || empty($body['idutilisateur'])) {
        throw new Exception("Le propriétaire est obligatoire.");
    }


    $databaseConnection = connectDB();

    $postbiensQuery = $databaseConnection->prepare("INSERT INTO bienimmobilier (adresse, type, description, superficie, nbChambres, tarif, idutilisateur) VALUES (:adresse, :type, :description, :superficie, :nbChambres, :tarif, :idutilisateur)");

    $postbiensQuery->execute([
        "adresse" => $body['adresse'],
        "type" => $body['type'],
        "description" => $body['description'],
        "superficie" => $body['superficie'],
        "nbChambres" => $body['nbchambres'],
        "tarif" => $body['tarif'],
        "idutilisateur" => $body['idutilisateur']
    ]);

    if ($postbiensQuery->rowCount() === 0) {
        throw new Exception("Erreur lors de l'ajout du bien.");
    }


    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Le bien a bien été ajouté."
    ]);
    ;

} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => "Erreur lors de l'ajout du bien."
    ]);
}