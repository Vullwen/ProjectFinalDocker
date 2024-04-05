<?php


require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/createUser.php";

try {
    $body = getBody();

    var_dump($body);

    $nom = $body["nom"];
    $prenom = $body["prenom"];
    $email = $body["email"];
    $telephone = $body["telephone"];
    $mdp = $body["mdp"];
    $mdp_confirm = $body["mdp_confirm"];

    if (!createUser($nom, $prenom, $email, $telephone, $mdp, $mdp_confirm)) {
        throw new Exception("Impossible de créer l'utilisateur");
    }

    echo jsonResponse(200, ["PCS" => "PCS2"], [
        "success" => true,
        "message" => "Utilisateur créee avec succès"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCS2"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}