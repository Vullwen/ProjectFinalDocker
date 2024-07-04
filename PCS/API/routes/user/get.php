<?php

require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $databaseConnection = connectDB();

    $idUtilisateur = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($idUtilisateur) {

        $query = $databaseConnection->prepare("SELECT idutilisateur, nom, prenom, email, telephone FROM utilisateur WHERE idutilisateur = :id");
        $query->bindParam(':id', $idUtilisateur, PDO::PARAM_INT);
    } else {

        $query = $databaseConnection->prepare("SELECT idutilisateur, nom, prenom, email, telephone FROM utilisateur");
    }

    $query->execute();
    $user = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($idUtilisateur && empty($user)) {
        echo jsonResponse(404, ["error" => "Utilisateur non trouvé"], []);
    } else {

        echo jsonResponse(200, ["success" => true], $user);
    }
} catch (Exception $exception) {
    echo jsonResponse(500, ["error" => $exception->getMessage()], []);
}
