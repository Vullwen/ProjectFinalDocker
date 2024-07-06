<?php
session_start();

$url = 'http://localhost:8080/api/user/login?email=' . $_GET['email'] . "&mdp=" . $_GET['mdp'];


$response = json_decode(file_get_contents($url, true));

if ($response->success) {
    $_SESSION['login'] = 1;
    $_SESSION['isAdmin'] = $response->result;
    $_SESSION['token'] = $response->token;
    $_SESSION['estBailleur'] = $response->isBailleur;
    header("Location: /site/index.php");
} else {
    header("Location: /site/src/login.php");
}