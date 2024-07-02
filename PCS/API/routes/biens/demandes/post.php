<?php

session_start();

include __DIR__ . "/../../../libraries/parameters.php";
include __DIR__ . "/../../../libraries/body.php";
include __DIR__ . "/../../../libraries/response.php";
include __DIR__ . "/../../../database/connectDB.php";

try {
    $databaseConnection = connectDB();

    if (!$databaseConnection) {
        die("La connexion à la base de données a échoué.");
    }

    $token = $_POST['token'];

    $getUserIDQuery = $databaseConnection->prepare("SELECT idutilisateur FROM utilisateur WHERE token = :token");
    $getUserIDQuery->bindParam(':token', $token);
    $getUserIDQuery->execute();
    $row = $getUserIDQuery->fetch(PDO::FETCH_ASSOC);

    $userId = $row['idutilisateur'];

    $targetDir = '/2A-ProjetAnnuel/PCS/Site/img/PhotosBienImmobilier/';

    $photoPaths = [];
    if (isset($_FILES['propertyPhotos'])) {
        foreach ($_FILES['propertyPhotos']['tmp_name'] as $index => $tmpName) {
            $originalName = basename($_FILES['propertyPhotos']['name'][$index]);
            $uniqueName = uniqid() . '-' . $originalName;
            $targetFilePath = $targetDir . $uniqueName;

            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $photoPaths[] = 'img/PhotosBienImmobilier/' . $uniqueName;
            }
        }
    }

    $postDemandeBienQuery = $databaseConnection->prepare("INSERT INTO demandebailleurs (type_conciergerie, autre_conciergerie, adresse, pays, type_bien, type_location, superficie, nombre_chambres, capacite, nom, description, email, telephone, heure_contact, date_demande, etat, utilisateur_id) VALUES (:type_conciergerie, :autre_conciergerie, :adresse, :pays, :type_bien, :type_location, :superficie, :nombre_chambres, :capacite, :nom, :description, :email, :telephone, :heure_contact, :date_demande, :etat, :utilisateur_id)");

    $success = $postDemandeBienQuery->execute([
        "type_conciergerie" => $_POST['conciergerie'],
        "autre_conciergerie" => $_POST['autreConciergerie'],
        "adresse" => $_POST['adresse'],
        "pays" => $_POST['pays'],
        "type_bien" => $_POST['typeBien'],
        "type_location" => $_POST['typeLocation'],
        "superficie" => $_POST['superficie'],
        "nombre_chambres" => $_POST['nombreChambres'],
        "capacite" => $_POST['capacite'],
        "description" => $_POST['description'],
        "nom" => $_POST['nom'],
        "email" => $_POST['email'],
        "telephone" => $_POST['telephone'],
        "heure_contact" => $_POST['contact'],
        "date_demande" => date("Y-m-d"),
        "etat" => "En attente",
        "utilisateur_id" => $userId
    ]);

    $demandeId = $databaseConnection->lastInsertId();

    if ($success && !empty($photoPaths)) {
        $insertPhotosQuery = $databaseConnection->prepare("INSERT INTO photobienimmobilier (IDdemande, cheminPhoto) VALUES (:IDdemande, :cheminPhoto)");
        foreach ($photoPaths as $path) {
            $insertPhotosQuery->execute([
                'IDdemande' => $demandeId,
                'cheminPhoto' => $path
            ]);
        }
    }

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
