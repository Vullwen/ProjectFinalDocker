<?php

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {
    $body = getBody();

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

    $success = $postbiensQuery->execute([
        "adresse" => $body['adresse'],
        "type" => $body['type'],
        "description" => $body['description'],
        "superficie" => $body['superficie'],
        "nbChambres" => $body['nbchambres'],
        "tarif" => $body['tarif'],
        "idutilisateur" => $body['idutilisateur']
    ]);

    if (!$success) {
        throw new Exception("Erreur lors de l'ajout du bien.");
    }

    $idbien = $databaseConnection->lastInsertId();

    if (isset($body['photos']) && !empty($body['photos'])) {
        $postPhotosQuery = $databaseConnection->prepare("INSERT INTO photobienimmobilier (idbien, cheminPhoto) VALUES (:idbien, :cheminPhoto)");

        foreach ($body['photos'] as $photo) {
            $successphotos = $postPhotosQuery->execute([
                "idbien" => $idbien,
                "cheminPhoto" => $photo
            ]);

        }
    }

    if (!$success && !$successphotos) {
        throw new Exception("Erreur lors de l'ajout du bien.");
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Le bien a bien été ajouté."
    ]);

} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => "Erreur lors de l'ajout du bien."
    ]);
}
