<?php

function isAuthenticated(string $role = "USER"): bool
{
    $headers = getallheaders();
    $authorizationHeader = $headers["Authorization"];
    $authorizationParts = explode(" ", $authorizationHeader);

    if (!isset($authorizationParts[0])) {
        return false;
    }

    if (!isset($authorizationParts[1])) {
        return false;
    }

    $authorizationType = $authorizationParts[0];
    $bearerToken = $authorizationParts[1];

    if ($authorizationType !== "Bearer") {
        return false;
    }

    require_once __DIR__ . "/../database/connectDB.php";

    $databaseConnection = connectDB();

    $getUserQuery = $databaseConnection = $databaseConnection->prepare("SELECT role FROM users WHERE token = :token");

    $success = $getUserQuery->execute([
        "token" => $bearerToken
    ]);

    if (!$success) {
        return false;
    }

    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return false;
    }

    if ($user["role"] !== $role) {
        return false;
    }

    return true;
}
