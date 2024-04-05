<?php

require_once __DIR__ . "/../database/connectDB.php";

function createUser(string $nom, string $prenom, string $email, string $telephone, string $mdp, string $mdp_confirm): bool
{
    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($mdp) || empty($mdp_confirm)) {
        return false;
    }

    if (!preg_match("/^[a-zA-Z-' ]*$/", $nom) || !preg_match("/^[a-zA-Z-' ]*$/", $prenom)) {
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    if (!preg_match("/^\d{10}$/", $telephone)) {
        return false;
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $mdp)) {
        return false;
    }

    if ($mdp != $mdp_confirm) {
        return false;
    }

    $conn = connectDB();

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE Email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return false;
    }

    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO utilisateur (Nom, Prenom, Email, Telephone, Mdp) VALUES (:nom, :prenom, :email, :telephone, :mdp)");
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":prenom", $prenom);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":telephone", $telephone);
    $stmt->bindParam(":mdp", $mdp_hash);
    if ($stmt->execute()) {
        return true;
    }

    return false;
}
