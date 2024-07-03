<?php

include __DIR__ . "/../../database/connectDB.php";
header("Content-Type: application/json; charset=UTF-8");

try {

    $idBien = $_GET['id'];
    $db = connectDB();

    $stmt = $db->prepare("SELECT COUNT(*) AS count FROM photobienimmobilier WHERE IDbien = ?");
    $stmt->execute([$idBien]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['count'] == 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'ID du bien immobilier invalide.']);
        exit;
    }

    $targetDir = "/var/www/html/2A-ProjetAnnuel/PCS/Site/";

    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        $data = json_decode(file_get_contents("php://input"), true);
        var_dump($data);

        if (!empty($data['photosToDelete'])) {
            $photosToDelete = json_decode($data['photosToDelete'], true);
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

            if ($stmt->execute($params)) {
                echo json_encode(['success' => true, 'message' => 'Les photos ont été supprimées avec succès.']);
            } else {
                throw new PDOException("Erreur lors de la suppression des photos de la base de données.");
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Aucune photo à supprimer spécifiée.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Méthode HTTP non autorisée.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression des photos.', 'error' => $e->getMessage()]);
}
