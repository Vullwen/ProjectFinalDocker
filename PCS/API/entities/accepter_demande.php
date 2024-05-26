<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connectDB.php";

$pdo = connectDB();
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

try {
    // Récupérer les informations de la demande
    $query = "SELECT * FROM demandes_prestataires WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $id]);
    $demande = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($demande) {
        $nom = $demande['nom'];
        $prenom = $demande['prenom'];
        $siret = $demande['siret'];
        $adresse = $demande['adresse'];
        $email = $demande['email'];
        $telephone = $demande['telephone'];
        $domaine = $demande['domaine'];
        $mdp = bin2hex(random_bytes(4)); // Générer un mot de passe aléatoire
        $hashed_mdp = password_hash($mdp, PASSWORD_BCRYPT);

        // Insérer dans la table prestataire
        $query = "INSERT INTO prestataire (Nom, Prenom, NSiret, Adresse, Email, Telephone, Domaine, Mdp) VALUES (:nom, :prenom, :siret, :adresse, :email, :telephone, :domaine, :mdp)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':siret' => $siret, // replace $nsiret with $siret
            ':adresse' => $adresse,
            ':email' => $email,
            ':telephone' => $telephone,
            ':domaine' => $domaine,
            ':mdp' => $hashed_mdp
        ]);


        // Mettre à jour le statut de la demande
        $query = "UPDATE demandes_prestataires SET status = 'Accepter' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $id]);

        // Optionnel : Envoyer un e-mail avec les détails de connexion
        // mail($email, "Votre compte a été créé", "Votre mot de passe est : " . $mdp);

        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Demande acceptée et prestataire ajouté.']);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Demande non trouvée.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'acceptation de la demande.', 'error' => $e->getMessage()]);
}
?>
