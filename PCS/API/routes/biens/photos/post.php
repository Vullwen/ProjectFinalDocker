<?php

include __DIR__ . "/../../../libraries/parameters.php";
include __DIR__ . "/../../../libraries/response.php";
include __DIR__ . "/../../../database/connectDB.php";

try {
    $db = connectDB();

    $idBien = $_GET['id'];

    $fullTargetDir = '/var/www/html/2A-ProjetAnnuel/PCS/Site/img/PhotosBienImmobilier/';

    $uploadedFiles = $_FILES['photos'] ?? [];

    $photoPaths = [];
    if (!empty($uploadedFiles)) {
        foreach ($uploadedFiles['tmp_name'] as $index => $tmpName) {
            $originalName = basename($uploadedFiles['name'][$index]);
            $uniqueName = uniqid() . '-' . $originalName;
            $targetFilePath = $fullTargetDir . $uniqueName;

            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $photoPaths[] = 'img/PhotosBienImmobilier/' . $uniqueName;
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement des photos.']);
                exit;
            }
        }

        $queryPrepared = $db->prepare("INSERT INTO photobienimmobilier (cheminPhoto, IDbien) VALUES (?, ?)");
        foreach ($photoPaths as $photoPath) {
            $queryPrepared->execute([$photoPath, $idBien]);
        }

        echo json_encode(['success' => true, 'message' => 'Les nouvelles photos ont été ajoutées avec succès.']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Aucune photo n\'a été envoyée.']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout des nouvelles photos.', 'error' => $e->getMessage()]);
}