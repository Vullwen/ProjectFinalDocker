<?php
session_start();

// Vérifiez si l'utilisateur est déjà connecté
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // L'utilisateur est connecté, redirigez-le vers la page d'accueil de l'admin ou toute autre page appropriée
    header("Location: PCS_ADMIN/index.php");
    exit();
} else {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: pages/login/login.php");
    exit();
}
?>
