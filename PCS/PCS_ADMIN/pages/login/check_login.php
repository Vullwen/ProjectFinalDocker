<?php
require_once __DIR__ . "/../../database/connectDB.php";
$db = connectDB(); // Ajoutez cette ligne
session_start();
$email = $_POST['email'];
$password = $_POST['password'];

$query = $db->prepare("SELECT * FROM utilisateur WHERE email = :email");
$query->execute(['email' => $email]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['Mdp'])) {
    // Si l'authentification échoue
    $_SESSION['error'] = "Identifiant incorrect.";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['admin_logged_in'] = true; // ou toute autre variable de session pertinente
    header("Location: ../../index.php"); // Redirection vers index.php
    exit();

}
?>