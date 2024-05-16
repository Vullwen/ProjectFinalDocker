<?php
session_start();
require_once '../API/database/connectDB.php';

if (!isset($_SESSION['IDPrestataire']) || !isset($_SESSION['token'])) {
    header('Location: ../Site/src/login.php');
    exit();
}

$IDPrestataire = $_SESSION['IDPrestataire'];
$token = $_SESSION['token'];

$conn = connectDB();
$query = "SELECT token FROM prestataire WHERE IDPrestataire = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $IDPrestataire);
$stmt->execute();
$result = $stmt->get_result();
$prestataire = $result->fetch_assoc();

if ($prestataire['token'] !== $token) {
    session_destroy();
    header('Location: ../Site/src/login.php');
    exit();
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/API/evaluation.php?IDPrestataire=$IDPrestataire");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$evaluations = json_decode(curl_exec($ch), true);
curl_close($ch);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Évaluations</title>
</head>
<body>
    <h1>Évaluations des Clients</h1>
    <ul>
        <?php foreach ($evaluations as $evaluation) : ?>
            <li><?php echo "Note: " . $evaluation['Note'] . " - Commentaire: " . $evaluation['Commentaire']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
