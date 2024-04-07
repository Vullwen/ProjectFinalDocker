<?php

function updateUser(string $id, $columns): void
{
    if (count($columns) === 0) {
        return;
    }

    require_once __DIR__ . "../database/connectDB.php";

    $authorizedColumns = ["email", "password", "token"];

    $set = [];

    $sanitizedColumns = [
        "id" => htmlspecialchars($id)
    ];

    foreach ($columns as $columnName => $columnValue) {
        if (!in_array($columnName, $authorizedColumns)) {
            continue;
        }

        $set[] = "$columnName = :$columnName";

        if ($columnName === "password") {
            $sanitizedColumns[$columnName] = password_hash($columnValue, PASSWORD_BCRYPT);
        } else {
            $sanitizedColumns[$columnName] = htmlspecialchars($columnValue);
        }
    }

    $set = implode(", ", $set);

    $databaseConnection = connectDB();
    $updateUserQuery = $databaseConnection->prepare("UPDATE utilisateur SET $set WHERE id = :id;");
    $updateUserQuery->execute($sanitizedColumns);
}
