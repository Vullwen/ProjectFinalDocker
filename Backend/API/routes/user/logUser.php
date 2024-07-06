<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../database/conf.inc.php";
require_once __DIR__ . "/../../libraries/token.php";
require_once __DIR__ . "/../../entities/loginUser.php";
session_start();
try {

    $email = $_GET['email'];
    $mdp = $_GET['mdp'];
    $result = loginUser($email, $mdp);

    if (!$result['success']) {
        throw new Exception(implode("\n", $result['errors']));
    }


    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Vous êtes connecté.",
        "result" => $result['isAdmin'],
        "token" => $result['token'],
        "isBailleur" => $result['isBailleur']
    ]);


} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}