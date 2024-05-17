<?php

session_start();

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {
    $body = getBody();

    $databaseConnection = connectDB();

    if (!$databaseConnection) {
        die("La connexion à la base de données a échoué.");
    }

    $token = $_SESSION['token'];

    $getUserIDQuery = $databaseConnection->prepare("SELECT idutilisateur FROM utilisateur WHERE token = :token");
    $getUserIDQuery->bindParam(':token', $token);
    $getUserIDQuery->execute();
    $row = $getUserIDQuery->fetch(PDO::FETCH_ASSOC);

    $userId = $row['idutilisateur'];

    $postDemandeBienQuery = $databaseConnection->prepare("INSERT INTO demandebailleurs (type_conciergerie, autre_conciergerie, adresse, pays, type_bien, type_location, nombre_chambres, capacite, nom, email, telephone, heure_contact, date_demande, etat, utilisateur_id) VALUES (:type_conciergerie, :autre_conciergerie, :adresse, :pays, :type_bien, :type_location, :nombre_chambres, :capacite, :nom, :email, :telephone, :heure_contact, :date_demande, :etat, :utilisateur_id)");

    $success = $postDemandeBienQuery->execute([
        "type_conciergerie" => $body['conciergerie'],
        "autre_conciergerie" => $body['autreConciergerie'],
        "adresse" => $body['adresse'],
        "pays" => $body['pays'],
        "type_bien" => $body['typeBien'],
        "type_location" => $body['typeLocation'],
        "nombre_chambres" => $body['nombreChambres'],
        "capacite" => $body['capacite'],
        "nom" => $body['nom'],
        "email" => $body['email'],
        "telephone" => $body['telephone'],
        "heure_contact" => $body['contact'],
        "date_demande" => date("Y-m-d"),
        "etat" => "En attente",
        "utilisateur_id" => $userId
    ]);
    ?>
    <script> console.log($body); </script>
    <?php


    $errorInfo = $postDemandeBienQuery->errorInfo();
    if ($errorInfo[0] !== '00000') {
        die("Erreur SQL : " . $errorInfo[2]);
    }


    if (!$success) {
        echo jsonResponse(500, ["PCS" => "PCError"], [
            "success" => false,
            "message" => "Erreur lors de l'ajout de la demande."
        ]);
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Demande ajoutée avec succès."
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}