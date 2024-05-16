<?php
require_once '../libraries/response.php';
require_once '../database/connectDB.php';
require_once '../libraries/parameters.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $params = getParameters();
    
    $Nom = htmlspecialchars($params['Nom']);
    $Prenom = htmlspecialchars($params['Prenom']);
    $NSiret = htmlspecialchars($params['NSiret']);
    $Adresse = htmlspecialchars($params['Adresse']);
    $Email = htmlspecialchars($params['Email']);
    $Telephone = htmlspecialchars($params['Telephone']);
    $Domaine = htmlspecialchars($params['Domaine']);
    $Mdp = password_hash($params['Mdp'], PASSWORD_BCRYPT);

    $conn = connectDB();
    $query = "INSERT INTO prestataire (Nom, Prenom, NSiret, Adresse, Email, Telephone, Domaine, Mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $Nom, $Prenom, $NSiret, $Adresse, $Email, $Telephone, $Domaine, $Mdp);
    
    if ($stmt->execute()) {
        sendResponse('success', 'Prestataire ajouté avec succès');
    } else {
        sendResponse('error', 'Erreur lors de l\'ajout du prestataire');
    }
    
    $stmt->close();
    $conn->close();
} else {
    sendResponse('error', 'Méthode non autorisée');
}
?>