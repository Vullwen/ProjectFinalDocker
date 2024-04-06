<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../database/conf.inc.php";
require_once __DIR__ . "/../../libraries/token.php";
require_once __DIR__ . "/../../entities/updateUser.php";

try {
    $body = getBody();

    $email = $body['email'];
    $mdp = $body['mdp'];

    $databaseConnection = connectDB();
    $getUserQuery = $databaseConnection->prepare("SELECT mdp FROM utilisateur WHERE email = :email");
    $getUserQuery->execute([
        "email" => $email
    ]);

    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Identifiants incorrects");
    }

    if (!password_verify($mdp, $user["mdp"])) {
        throw new Exception("Identifiants incorrects");
    }

    $token = bin2hex(random_bytes(16));

    $updateTokenQuery = $databaseConnection->prepare("UPDATE utilisateur
    SET token = :token
    WHERE email = :email");
    $updateTokenQuery->execute([
        "token" => $token,
        "email" => $email
    ]);

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "token" => $token
    ]);

} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => [$exception->getMessage()]
    ]);
}
?>