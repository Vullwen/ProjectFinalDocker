<?php

require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/createUser.php";

try {
    $body = getBody();

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
        "redirect" => "login.php"
    ]);

} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}
