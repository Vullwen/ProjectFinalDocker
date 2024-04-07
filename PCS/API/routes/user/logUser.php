<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../database/conf.inc.php";
require_once __DIR__ . "/../../libraries/token.php";
require_once __DIR__ . "/../../entities/loginUser.php";

try {
    $body = getBody();

    $email = $body['email'];
    $mdp = $body['mdp'];

    $result = loginUser($email, $mdp);

    if (!$result['success']) {
        throw new Exception(implode("\n", $result['errors']));
    }

    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Vous êtes connecté."
    ]);


} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}