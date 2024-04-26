<?php

require_once __DIR__ . "/../database/connectDB.php";
require_once __DIR__ . "/../libraries/token.php";

function loginUser(string $email, string $mdp): array|bool
{
    $errors = [];
    $databaseConnection = connectDB();

    $getUserQuery = $databaseConnection->prepare("SELECT mdp, DroitAdmin FROM utilisateur WHERE email = :email");
    $getUserQuery->execute([
        "email" => $email
    ]);

    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);


    if (!$user) {
        $errors[] = "Identifiants incorrects.";
    }

    if (!password_verify($mdp, $user["mdp"])) {
        $errors[] = "Identifiants incorrects.";
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $token = getAuthenticationToken();

    $updateTokenQuery = $databaseConnection->prepare("UPDATE utilisateur
    SET token = :token
    WHERE email = :email");

    $updateTokenQuery->execute([
        "token" => $token,
        "email" => $email
    ]);


    return ['success' => true, 'message' => 'Connexion établie', 'isAdmin' => $user['DroitAdmin'], 'token' => $token];

}