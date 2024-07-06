<?php

require_once __DIR__ . "/../database/connectDB.php";

function createUser(string $nom, string $prenom, string $email, string $telephone, string $mdp, string $mdp_confirm)
{
    $errors = [];
    $conn = connectDB();

    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($mdp) || empty($mdp_confirm)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!preg_match("/^[a-zA-Z-' ]*$/", $nom) || !preg_match("/^[a-zA-Z-' ]*$/", $prenom)) {
        $errors[] = "Le nom et le prénom ne doivent contenir que des lettres et des espaces.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    if (!preg_match("/^\d{10}$/", $telephone)) {
        $errors[] = "Le numéro de téléphone doit contenir 10 chiffres.";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $mdp)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères dont au moins une lettre minuscule, une lettre majuscule et un chiffre.";
    }

    if ($mdp != $mdp_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE Email=:email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $errors[] = "L'adresse email est déjà utilisée.";
    }


    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO utilisateur (Nom, Prenom, Email, Telephone, Mdp) VALUES (:nom, :prenom, :email, :telephone, :mdp)");
    $stmt->bindParam(":nom", $nom);
    $stmt->bindParam(":prenom", $prenom);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":telephone", $telephone);
    $stmt->bindParam(":mdp", $mdp_hash);
    if ($stmt->execute()) {

        return ['success' => true, 'message' => 'Utilisateur créé avec succès.'];
    }
    return ['success' => false, 'message' => 'Impossible de créer l\'utilisateur.'];
}
