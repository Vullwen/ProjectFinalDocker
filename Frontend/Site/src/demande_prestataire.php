<?php
include_once '../template/header.php';
?>

<h1>Demande d'inscription comme Prestataire</h1>
<div class="container mt-5">
    <form id="prestataireForm">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" required><br>
        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" required><br>
        <label for="siret">Numéro SIRET:</label><br>
        <input type="text" id="siret" name="siret" required><br>
        <label for="adresse">Adresse:</label><br>
        <input type="text" id="adresse" name="adresse" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="telephone">Téléphone:</label><br>
        <input type="text" id="telephone" name="telephone" required><br>
        <label for="domaine">Domaine:</label><br>
        <input type="text" id="domaine" name="domaine" required><br>
        <input type="submit" class="btn-primary" value="Envoyer">
    </form>
</div>
<script src="../javascript/demande_prestataires.js"></script>