<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    require_once __DIR__ . "/../../database/connectDB.php";
    $db = connectDB();


    $idBien = $_GET['id'];

    $type_bien = $input['Type_bien'];
    $adresse = $input['Adresse'];
    $superficie = $input['Superficie'];
    $description = $input['Description'];
    $nbChambres = $input['NbChambres'];


    $updateQuery = $db->prepare("UPDATE bienimmobilier SET Type_bien = :type_bien, Adresse = :adresse, Description = :description, superficie = :superficie, NbChambres = :nbChambres WHERE IDBien = :idBien");


    $updateQuery->execute([
        'type_bien' => $type_bien,
        'adresse' => $adresse,
        'description' => $description,
        'superficie' => $superficie,
        'nbChambres' => $nbChambres,
        'idBien' => $idBien
    ]);

    if ($updateQuery->rowCount() > 0) {
        $response = [
            'success' => true,
            'message' => 'Les informations du bien immobilier ont été mises à jour avec succès.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Aucun changement détecté pour la mise à jour du bien immobilier.'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du bien immobilier.', 'error' => $e->getMessage()]);
}

