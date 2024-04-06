<?php

require_once __DIR__ . "/../database/connectDB.php";

function loginUser(string $email, string $mdp): array
{
    $databaseConnection = connectDB();

    $getUserQuery = $databaseConnection->prepare("SELECT * FROM utilisateur WHERE email = :email");
    $getUserQuery->execute([
        "email" => $email
    ]);

    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return [
            "success" => false,
            "errors" => ["Identifiants incorrects"]
        ];
    }

    if (!password_verify($mdp, $user["mdp"])) {
        return [
            "success" => false,
            "errors" => ["Identifiants incorrects"]
        ];
    }

    $token = bin2hex(random_bytes(16));

    $updateTokenQuery = $databaseConnection->prepare("UPDATE utilisateur SET token = :token WHERE email = :email");
    $updateTokenQuery->execute([
        "token" => $token,
        "email" => $email
    ]);

    return [
        "success" => true,
        "token" => $token
    ];
} {

}