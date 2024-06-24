<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include __DIR__ . "/../../libraries/parameters.php";
include __DIR__ . "/../../libraries/body.php";
include __DIR__ . "/../../libraries/response.php";
include __DIR__ . "/../../database/connectDB.php";

try {
    $db = connectDB();
    $bienId = $_GET['bienId'];
    $userId = $_GET['userId'];

    $dbquery = $db->prepare("
        SELECT r.*, u.nom, u.email, u.telephone 
        FROM reservation r
        JOIN utilisateur u ON r.IDUtilisateur = u.IDUtilisateur
        WHERE r.IDBien = :IDBien AND u.IDUtilisateur = :IDUtilisateur
    ");
    $dbquery->execute(['IDBien' => $bienId, 'IDUtilisateur' => $userId]);
    $reservations = $dbquery->fetchAll(PDO::FETCH_ASSOC);

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "reservations" => $reservations
    ]);

} catch (Exception $exception) {
    echo jsonResponse(500, ["PCS" => "PCError"], [
        "success" => false,
        "message" => $exception->getMessage()
    ]);
}

function getUserIdFromToken()
{
    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        throw new Exception("Token d'authentification manquant");
    }

    $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
    $token = str_replace('Bearer ', '', $authorizationHeader);

    // Vous devez implémenter la logique pour valider et décoder le token
    // Dans ce cas, vous pourriez vérifier le token en BDD et récupérer l'ID utilisateur associé
    $db = connectDB();
    $stmt = $db->prepare("SELECT IDUtilisateur FROM utilisateur WHERE token = ?");
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        throw new Exception("Token invalide ou expiré");
    }

    return $row['IDUtilisateur'];
}
?>