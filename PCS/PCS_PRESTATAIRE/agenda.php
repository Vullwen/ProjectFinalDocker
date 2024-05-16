<?php
session_start();
require_once '../API/database/connectDB.php';

if (!isset($_SESSION['IDPrestataire'])) {
    header('Location: login.php');
    exit();
}

$IDPrestataire = $_SESSION['IDPrestataire'];

$conn = connectDB();
$query = "SELECT * FROM prestation WHERE IDPrestataire = :idPrestataire";
$stmt = $conn->prepare($query);
$stmt->execute(['idPrestataire' => $IDPrestataire]);
$prestations = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Agenda des Prestations</title>
</head>
<body>
    <h1>Votre Agenda</h1>
    <ul>
        <?php foreach ($prestations as $prestation) : ?>
            <li><?php echo "Type: " . $prestation['Type'] . " - Description: " . $prestation['Description'] . " - Date: " . $prestation['Date']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
