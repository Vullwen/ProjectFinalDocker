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

    if (!isset($body['type_bien']) || empty($body['type_bien'])) {
        throw new Exception("Le type est obligatoire.");
    }

    if (!isset($body['type_conciergerie']) || empty($body['type_conciergerie'])) {
        throw new Exception("Le type de conciergerie est obligatoire.");
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

    $postbiensQuery = $databaseConnection->prepare("
        INSERT INTO bienimmobilier 
        (adresse, type_bien, description, superficie, nbChambres, tarif, type_conciergerie, idutilisateur, pays, type_location, capacite)
        VALUES 
        (:adresse, :type_bien, :description, :superficie, :nbChambres, :tarif, :type_conciergerie, :idutilisateur, :pays, :type_location, :capacite)
    ");

    $success = $postbiensQuery->execute([
        "adresse" => $body['adresse'],
        "type_bien" => $body['type_bien'],
        "description" => $body['description'],
        "superficie" => $body['superficie'],
        "nbChambres" => $body['nbChambres'],
        "tarif" => $body['tarif'],
        "type_conciergerie" => $body['type_conciergerie'],
        "idutilisateur" => $body['idutilisateur'],
        "pays" => $body['pays'],
        "type_location" => $body['type_location'],
        "capacite" => $body['capacite']
    ]);

    if (!$success) {
        throw new Exception("Erreur lors de l'ajout du bien.");
    }

    $uploadDirectory = "/../../Site/img/photosBI/";


    if (isset($body['files']) && !empty($body['files'])) {
        $uploadedFiles = $_body['files'];

        foreach ($uploadedFiles['tmp_name'] as $key => $tmpName) {
            $fileName = $uploadedFiles['name'][$key];
            $filePath = $uploadDirectory . $fileName;

            if (!move_uploaded_file($tmpName, $filePath)) {
                throw new Exception("Erreur lors de l'enregistrement du fichier $fileName.");
            }
        }
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



    if (!$success) {
        throw new Exception("Erreur lors de l'ajout du bien.");
    }



    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Le bien a été ajouté."
    ]);

} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}
