<?php
include_once '../../../Site/template/header.php';
require_once '../../../API/database/connectDB.php';

if (isAdmin()) {
    ?>
    <div class="container mt-5">
        <h2>Liste des Biens Immobiliers</h2>
        <div class="search-box">
            <input type="text" id="searchInputBiens" class="form-control" onkeyup="searchBiens()"
                placeholder="Rechercher des biens...">
        </div>
        <div class="row" id="biensContainer">
        </div>
        <a href="../../index.php" class="btn btn-primary">Retour au menu Admin</a>
    </div>

    <?php
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Vous n'êtes pas autorisé à accéder à cette page.</p>";
    echo "</div>";

}
include_once '../../../Site/template/footer.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function loadBiens() {
        $.ajax({
            url: 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success && response.properties && response.properties.length > 0) {
                    var biensContainer = document.getElementById('biensContainer');
                    biensContainer.innerHTML = '';

                    response.properties.forEach(function (bien) {
                        var cardHtml = `
                                <div class='col-md-4 mb-4'>
                                    <a href='details_bien.php?id=${bien.IDBien}' class='card-link'>
                                        <div class='card' style='cursor: pointer;'>
                                            <img src='../../img/home_icon.png' class='card-img-top small-image' alt='...'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>${bien.Type_bien}</h5>
                                                <p class='card-text'>Adresse: ${bien.Adresse}</p>
                                                <p class='card-text'>Description: ${bien.Description}</p>
                                                <p class='card-text'>Superficie: ${bien.Superficie}</p>
                                                <p class='card-text'>Nombre de Chambres: ${bien.NbChambres}</p>
                                                <p class='card-text'>Tarif: ${bien.Tarif} € / nuit</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `;
                        biensContainer.insertAdjacentHTML('beforeend', cardHtml);
                    });
                } else {
                    var biensContainer = document.getElementById('biensContainer');
                    biensContainer.innerHTML = '<p>Aucun bien immobilier trouvé.</p>';
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors du chargement des biens:', error);
                var biensContainer = document.getElementById('biensContainer');
                biensContainer.innerHTML = '<p>Une erreur s\'est produite lors du chargement des biens immobiliers.</p>';
            }
        });
    }

    $(document).ready(function () {
        loadBiens();
    });

    function searchBiens() {
        var input, filter, cards, card, title, i, txtValue;
        input = document.getElementById("searchInputBiens");
        filter = input.value.toUpperCase();
        cards = document.getElementById("biensContainer").getElementsByClassName("card");

        for (i = 0; i < cards.length; i++) {
            card = cards[i];
            title = card.querySelector(".card-title");
            if (title) {
                txtValue = title.textContent || title.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    }
</script>