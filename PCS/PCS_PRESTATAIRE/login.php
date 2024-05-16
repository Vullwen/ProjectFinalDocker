<?php
session_start();
require_once '../API/database/connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Mdp = $_POST['Mdp'];

    $conn = connectDB();
    $query = "SELECT * FROM prestataire WHERE Nom = :nom AND Prenom = :prenom";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':nom' => $Nom, 
        ':prenom' => $Prenom
    ]);
    $prestataire = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prestataire && password_verify($Mdp, $prestataire['Mdp'])) {
        $_SESSION['IDPrestataire'] = $prestataire['IDPrestataire'];
        $_SESSION['Nom'] = $prestataire['Nom'];
        $_SESSION['Prenom'] = $prestataire['Prenom'];
        header('Location: index.php');
    } else {
        $error = "Nom, Prénom ou Mot de Passe incorrect.";
    }

    $stmt = null;  /
    $conn = null;  
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Prestataire</title>
</head>
<body>
    <h1>Connexion Prestataire</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="">
        <label>Nom: <input type="text" name="Nom" required></label><br>
        <label>Prénom: <input type="text" name="Prenom" required></label><br>
        <label>Mot de Passe: <input type="password" name="Mdp" required></label><br>
        <button type="submit">Se Connecter</button>
    </form>
</body>
</html>
