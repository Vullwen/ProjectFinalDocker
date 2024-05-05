<?php
session_start();

$url = 'http://localhost/2A-ProjetAnnuel/PCS/API/user?email=' . $_GET['email'] . "&mdp=" . $_GET['mdp'];


$response = json_decode(file_get_contents($url, true));


if ($response->success) {
    $_SESSION['login'] = 1;
    $_SESSION['isAdmin'] = $response->result;
    $_SESSION['token'] = $response->token;
    header("Location: /2A-ProjetAnnuel/PCS/Site/index.php");
} else {
    header("Location: /2A-ProjetAnnuel/PCS/Site/src/login.php");
}