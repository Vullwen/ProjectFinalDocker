<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../database/connectDB.php";
require_once __DIR__ . "/../../database/conf.inc.php";

try {
    $body = getBody();

    if (!isset($body['email']) || !isset($body['mdp'])) {

        echo jsonResponse(400, ["PCS" => "PCSFail"], [
            "success" => false,
            "error" => "Tous les champs sont obligatoires."
        ]);
        exit();
    }

    $email = $body['email'];
    $mdp = $body['mdp'];

    // Verifications
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT mdp FROM utilisateur WHERE email=:email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($mdp, $user['mdp'])) {
        echo jsonResponse(401, ["PCS" => "PCSFail"], [
            "success" => false,
            "error" => "Adresse email ou mot de passe incorrect."
        ]);
        exit();
    }





    // Si la connexion réussit, vous pouvez générer un token d'authentification et le renvoyer dans la réponse JSON

    // Exemple de réponse JSON en cas de succès
    echo jsonResponse(200, ["PCS" => "PCSuccess"], [
        "success" => true,
        "message" => "Connexion réussie. Utilisateur connecté.",
        // Vous pouvez également inclure d'autres données utiles dans la réponse, comme le token d'authentification
        "token" => "votre_token_d'authentification"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["PCS" => "PCSFail"], [
        "success" => false,
        "errors" => explode("\n", $exception->getMessage())
    ]);
}