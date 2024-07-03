<?php

include __DIR__ . "/../../database/connectDB.php";
header("Content-Type: application/json; charset=UTF-8");

try {

    $targetDir = "/var/www/html/2A-ProjetAnnuel/PCS/Site/";

    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        parse_str(file_get_contents("php://input"), $data);

        if (!empty($data['photosToDelete[]'])) {
            $photosToDelete = json_decode($data['photosToDelete[]'], true);
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
                foreach ($photosToDelete as $photoPath) {
                    $filePath = "/var/www/html/2A-ProjetAnnuel/PCS/Site/" . $photoPath;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            } else {
                throw new PDOException("Erreur lors de la suppression des photos de la base de données.");
            }
        }

    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression des photos.', 'error' => $e->getMessage()]);
}
