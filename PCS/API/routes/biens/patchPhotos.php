<?php

include __DIR__ . "/../../database/connectDB.php";
header("Content-Type: application/json; charset=UTF-8");

try {
    $targetDir = "/var/www/html/2A-ProjetAnnuel/PCS/Site/";

    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        parse_str(file_get_contents("php://input"), $data);
        var_dump($data['photosToDelete']);

        if (!empty($data['photosToDelete'])) {
            $photosToDelete = $data['photosToDelete'];
            foreach ($photosToDelete as $photoPath) {
                $filePath = $targetDir . $photoPath;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $placeholders = rtrim(str_repeat('?,', count($photosToDelete)), ',');
            $sql = "DELETE FROM photobienimmobilier WHERE cheminPhoto IN ($placeholders)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute($photosToDelete)) {
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
