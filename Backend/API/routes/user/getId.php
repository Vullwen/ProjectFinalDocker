<?php
session_start();
require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";

$token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);

try {
    $pdo = connectDB();

    $stmt = $pdo->prepare("SELECT IDUtilisateur FROM utilisateur WHERE token = :token");
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Aucun utilisateur trouvé avec ce token.']);
        exit();
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'user_id' => $user['IDUtilisateur']]);
    exit();

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération de l\'ID de l\'utilisateur.', 'error' => $e->getMessage()]);
    exit();
}
?>