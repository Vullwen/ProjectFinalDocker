<?php

include_once "../../template/header.php";

?>
<div class='container mt-5'>
    <h2>Ajouter un Nouveau Bien Immobilier</h2>
    <form id="ajouterBienForm" method=' POST'>
        <div class='form-group'>
            <label for='type'>Type<span class='obligatoire'>
                    (obligatoire)</span></label>
            <input type='text' class='form-control' id='type' name='type' required>
        </div>
        <div class='form-group'>
            <label for='adresse'>Adresse<span class='obligatoire'>
                    (obligatoire)</span></label>
            <input type='text' class='form-control' id='adresse' name='adresse' required>
        </div>
        <div class='form-group'>
            <label for='description'>Description<span class='obligatoire'>
                    (obligatoire)</span></label>
            <textarea class='form-control' id='description' name='description' rows='3' required></textarea>
        </div>
        <div class='form-group'>
            <label for='superficie'>Superficie<span class='obligatoire'>
                    (obligatoire)</span></label>
            <input type='number' class='form-control' id='superficie' name='superficie' required>
        </div>
        <div class='form-group'>
            <label for='nbChambres'>Nombre de Chambres<span class='obligatoire'>
                    (obligatoire)</span></label>
            <input type='number' class='form-control' id='nbChambres' name='nbChambres' required>
        </div>
        <div class='form-group'>
            <label for='conciergerie'>Quel type de conciergerie souhaitez-vous ?<span class='obligatoire'>
                    (obligatoire)</span></label><br>
            <input type='radio' id='aaz' name='conciergerie' value='De A à Z'>
            <label for='aaz'>De A à Z</label><br>
            <input type='radio' id='void' name='conciergerie' value='Void management'>
            <label for='void'>Void management (création, diffusion et optimisatioon de vos revenus)</label><br>
            <input type='radio' id='autre' name='conciergerie' value='Autre'>
            <label for='autre'>Autre</label><br>
            <input type='text' id='autreConciergerie' name='autreConciergerie' placeholder='Autre (précisez)'>
        </div>
        <div class="btn-center">
            <button type='submit' class='btn btn-primary'>Ajouter le Bien</button>
        </div>
        <input type="hidden" id="userToken" value="<?php echo $_SESSION['token']; ?>">
    </form>
</div>

<script src="http://51.75.69.184/2A-ProjetAnnuel/PCS/Site/javascript/ajout_biens.js"></script>
</script>
<?php

include_once "../../template/footer.php";

