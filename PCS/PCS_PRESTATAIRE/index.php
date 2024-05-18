<?php
session_start();
require_once '../API/database/connectDB.php';

if (!isset($_SESSION['IDPrestataire'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Prestataire</title>
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['Prenom'] . ' ' . $_SESSION['Nom']; ?>!</h1>
    <ul>
        <li><a href="agenda.php">Voir l'Agenda</a></li>
        <li><a href="avis.php">Voir les Avis</a></li>
        <li><a href="ajout_prestataire.php">Demande d'Ajout de Prestataire</a></li>
    </ul>
</body>
</html>
