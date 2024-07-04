<?php

require_once __DIR__ . "/../../database/connectDB.php";

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $userId = $_GET['id'];
        $email = $input['email'];
        $telephone = $input['telephone'];
        $currentPassword = $input['currentPassword'];
        $newPassword = isset($input['newPassword']) ? $input['newPassword'] : null;

        $db = connectDB();

        $stmt = $db->prepare("SELECT Mdp FROM utilisateur WHERE IDUtilisateur = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user['Mdp'])) {
            echo json_encode(['success' => false, 'message' => 'Mot de passe actuel incorrect']);
            exit();
        }

        $query = "UPDATE utilisateur SET email = :email, telephone = :telephone";
        if ($newPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $query .= ", Mdp = :newPassword";
        }
        $query .= " WHERE IDUtilisateur = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        if ($newPassword) {
            $stmt->bindParam(':newPassword', $hashedPassword);
        }
        $stmt->bindParam(':id', $userId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Informations mises à jour avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des informations']);
        }
    }




} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'utilisateur.', 'error' => $e->getMessage()]);
}

