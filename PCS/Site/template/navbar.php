<?php
include (dirname(__DIR__) . "/functions/isAdmin.php");
include (dirname(__DIR__) . "/functions/estBailleur.php");
include (dirname(__DIR__) . "../../API/entities/isAuthenticated.php");


?>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="/2A-ProjetAnnuel/PCS/Site/img/LOGO.png" alt="LOGO" width="70px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="/2A-ProjetAnnuel/PCS/Site/index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/services.php">Services</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/contact.php">Contact</a>
                </li>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/recherche.php">Logement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/demande_prestataire.php">Devenir
                        Prestataire PCS </a>
                </li>
                <?php
                if (isAdmin()) {
                    echo '<li class="nav-item">
                                    <a class="nav-link"
                                        href="/2A-ProjetAnnuel/PCS/PCS_ADMIN/index.php">Admin</a>
                                </li>';
                }

                if (isset($_SESSION['token'])) {
                    if (estBailleur()) {
                        echo '<li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/biens/biensListe.php">Mes Biens</a>
                </li>';
                        echo '<li class="nav-item">
                <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/remplirTicket.php">Assistance</a>
            </li>';
                    } else {
                        echo '<li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/registerBailleur.php">Devenir Bailleur</a>
                </li>';

                    }
                    echo '<li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/mesReservation.php">Mes Réservations</a>
                </li>';

                    echo '<li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/profil.php">Mon Profil</a>
                    </li>';

                    echo '<li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/functions/logout.php">Déconnexion</a>
                </li>';


                } else {
                    echo '<li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/login.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/2A-ProjetAnnuel/PCS/Site/src/register.php">Inscription</a>
                </li>';
                }


                ?>
            </ul>
        </div>
    </div>
</nav>