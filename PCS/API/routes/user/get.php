<?php

require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";


require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../database/connectDB.php";

try {


    $databaseConnection = connectDB();

    $query = $databaseConnection->prepare("SELECT idutilisateur, nom, prenom, email, telephone FROM utilisateur WHERE EstBailleur = 1");
    $query->execute();

    $bailleurs = $query->fetchAll(PDO::FETCH_ASSOC);

    echo jsonResponse(200, [], $bailleurs);
} catch (Exception $exception) {
    echo jsonResponse(500, ["error" => $exception->getMessage()], []);
}