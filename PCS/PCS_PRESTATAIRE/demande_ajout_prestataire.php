<?php
session_start();
require_once '../API/database/connectDB.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $siret = $_POST['siret'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $domaine = $_POST['domaine'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);

    $conn = connectDB();
    $query = "INSERT INTO demandes_prestataires (nom, prenom, siret, adresse, email, telephone, domaine, mdp, status) 
              VALUES (:nom, :prenom, :siret, :adresse, :email, :telephone, :domaine, :mdp, :status)";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':siret' => $siret,
        ':adresse' => $adresse,
        ':email' => $email,
        ':telephone' => $telephone,
        ':domaine' => $domaine,
        ':mdp' => $mdp,
        ':status' => 'En attente'
    ]);

    if ($stmt->rowCount() > 0) {
        echo "Demande envoyée avec succès.";
    } else {
        echo "Erreur lors de l'envoi de la demande.";
    }

    $stmt = null; // Closing statement
    $conn = null; // Closing connection
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Demande pour ajouter un nouveau prestataire</title>
</head>

<body>
    <h1>Demande pour ajouter un nouveau prestataire</h1>
    <form method="post" action="">
        <label>Nom: <input type="text" name="nom" required></label><br>
        <label>Prénom: <input type="text" name="prenom" required></label><br>
        <label>N° Siret: <input type="text" name="siret" required></label><br>
        <label>Adresse: <input type="text" name="adresse" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Téléphone: <input type="text" name="telephone" required></label><br>
        <label>Domaine: <input type="text" name="domaine" required></label><br>
        <label>Mot de Passe: <input type="password" name="mdp" required></label><br>
        <button type="submit">Envoyer la demande</button>
    </form>
</body>

</html>