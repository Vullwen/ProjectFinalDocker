<?php
session_start();
require_once 'database/connectDB.php';

if (!isset($_SESSION['IDPrestataire'])) {
    header('Location: login.php');
    exit();
}

$IDPrestataire = $_SESSION['IDPrestataire'];

$conn = connectDB();
$query = "SELECT e.Note, e.Commentaire FROM evaluation e JOIN prestation p ON e.IDPrestation = p.IDPrestation WHERE p.IDPrestataire = :idPrestataire";
$stmt = $conn->prepare($query);
$stmt->execute(['idPrestataire' => $IDPrestataire]);
$evaluations = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Avis</title>
</head>
<body>
    <h1>Avis sur les Prestations</h1>
    <ul>
        <?php foreach ($evaluations as $evaluation) : ?>
            <li><?php echo "Note: " . $evaluation['Note'] . " - Commentaire: " . $evaluation['Commentaire']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
