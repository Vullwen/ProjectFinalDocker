<?php

include_once '../template/header.php';

?>

<h1> Remplir un ticket </h1>

<h2> Vous pouvez demander de l'assistance aux administrateurs de PCS en remplissant un ticket </h2>

<form id="remplirTicketForm" method=' POST'>
    <div class='form-group'>
        <label for="Catégorie">Catégorie<span class='obligatoire'>
                (obligatoire)</span></label>
        <select class='form-control' id='categorie' name='categorie' required>
            <option value=''>Choisissez une catégorie</option>
            <option value='Bailleur'>Bailleur</option>
            <option value='Prestataire'>Prestataire</option>
        </select>

        <label for="description">Description<span class='obligatoire'>
                (obligatoire)</span></label>
        <textarea class='form-control' id='description' name='description' rows='3' required></textarea>


    </div>

    <div class="btn-center">
        <button type='submit' class='btn btn-primary'>Envoyer le ticket</button>
    </div>
    <input type="hidden" id="userToken" value="<?php echo $_SESSION['token']; ?>">