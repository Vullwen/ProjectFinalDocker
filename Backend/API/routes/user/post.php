<?php
require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/createUser.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    $body = getBody();

    if (is_null($body)) {
        throw new Exception("Invalid JSON input");
    }

    $nom = $body["nom"];
    $prenom = $body["prenom"];
    $email = $body["email"];
    $telephone = $body["telephone"];
    $mdp = $body["mdp"];
    $mdp_confirm = $body["mdp_confirm"];

    $result = createUser($nom, $prenom, $email, $telephone, $mdp, $mdp_confirm);
    if (!$result['success']) {
        throw new Exception(implode("\n", $result['errors']));
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Utilisateur créé avec succès. Vous pouvez maintenant vous connecter.",
    ]);

} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}
?>
