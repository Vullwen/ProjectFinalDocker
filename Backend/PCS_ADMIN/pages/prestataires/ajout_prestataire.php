<?php
session_start();
require_once '../../../API/database/connectDB.php';
require_once '../../../Site/functions/isAdmin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $NSiret = $_POST['NSiret'];
    $Adresse = $_POST['Adresse'];
    $Email = $_POST['Email'];
    $Telephone = $_POST['Telephone'];
    $Domaine = $_POST['Domaine'];
    $Mdp = password_hash($_POST['Mdp'], PASSWORD_BCRYPT);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/entities/ajout_prestataire_admin.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['Nom' => $Nom, 'Prenom' => $Prenom, 'NSiret' => $NSiret, 'Adresse' => $Adresse, 'Email' => $Email, 'Telephone' => $Telephone, 'Domaine' => $Domaine, 'Mdp' => $Mdp]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if ($response['status'] == 'success') {
        echo "Prestataire ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du prestataire.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ajout d'un Prestataire</title>
</head>

<body>
    <h1>Ajouter un Nouveau Prestataire</h1>
    <form method="post" action="">
        <label>Nom: <input type="text" name="Nom" required></label><br>
        <label>Prénom: <input type="text" name="Prenom" required></label><br>
        <label>N° Siret: <input type="text" name="NSiret" required></label><br>
        <label>Adresse: <input type="text" name="Adresse" required></label><br>
        <label>Email: <input type="email" name="Email" required></label><br>
        <label>Téléphone: <input type="text" name="Telephone" required></label><br>
        <label>Domaine: <input type="text" name="Domaine" required></label><br>
        <label>Mot de Passe: <input type="password" name="Mdp" required></label><br>
        <button type="submit">Ajouter le Prestataire</button>
    </form>
</body>

</html>