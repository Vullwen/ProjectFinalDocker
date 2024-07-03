<?php

include __DIR__ . "/../../database/connectDB.php";
header("Content-Type: application/json; charset=UTF-8");

try {
    $db = connectDB();

    $idBien = $_GET['id'];
    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM photobienimmobilier WHERE IDbien = ?");
    $stmt->execute([$idBien]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['count'] == 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'ID du bien immobilier invalide.']);
        exit;
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la vérification de l\'ID du bien immobilier.', 'error' => $e->getMessage()]);
    exit;
}

$targetDir = "/var/www/html/2A-ProjetAnnuel/PCS/Site/";
$fullTargetDir = '/var/www/html/2A-ProjetAnnuel/PCS/Site/img/PhotosBienImmobilier/';

$data = json_decode(file_get_contents('php://input'), true);
$photosToDelete = $data['photosToDelete'] ?? [];

$uploadedFiles = $_FILES['photos'] ?? [];
var_dump($uploadedFiles);
$photoPaths = [];

if (isset($uploadedFiles['tmp_name'])) {
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
}

try {
    if (!empty($photoPaths)) {
        $queryPrepared = $db->prepare("INSERT INTO photobienimmobilier (cheminPhoto, IDbien) VALUES (?, ?)");
        foreach ($photoPaths as $photoPath) {
            $queryPrepared->execute([$photoPath, $idBien]);
        }
    }

    if (!empty($photosToDelete)) {
        foreach ($photosToDelete as $photoPath) {
            $filePath = $targetDir . $photoPath;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $placeholders = rtrim(str_repeat('?,', count($photosToDelete)), ',');
        $sql = "DELETE FROM photobienimmobilier WHERE cheminPhoto IN ($placeholders) AND IDbien = ?";
        $stmt = $db->prepare($sql);
        $params = array_merge(array_values($photosToDelete), [$idBien]);

        if (!$stmt->execute($params)) {
            throw new PDOException("Erreur lors de la suppression des photos de la base de données.");
        }
    }

    echo json_encode(['success' => true, 'message' => 'Les modifications des photos ont été effectuées avec succès.']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification des photos.', 'error' => $e->getMessage()]);
}
