uel/2A-ProjetAnnuel<?php
include (dirname(__DIR__) . "/functions/isAdmin.php");
include (dirname(__DIR__) . "/functions/estBailleur.php");

function fetchAuthenticatedStatus()
{
    $url = "http://backend:80/api/entities/isAuthenticated.php";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $output = curl_exec($ch);
    curl_close($ch);

    return $output;
}

$authenticatedStatus = fetchAuthenticatedStatus();


?>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="/site/img/LOGO.png" alt="LOGO" width="70px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="/site/index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/site/src/services.php">Services</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/site/src/contact.php">Contact</a>
                </li>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/site/src/recherche.php">Logement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/site/src/demande_prestataire.php">Devenir
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
                    if (!estBailleur()) {
                        echo '<li class="nav-item">
                        <a class="nav-link" href="/site/src/registerBailleur.php">Devenir Bailleur</a>
                    </li>';

                    } else {
                        echo '<li class="nav-item">
                    <a class="nav-link" href="/site/src/remplirTicket.php">Assistance</a>
                </li>';

                    }

                    echo '<li class="nav-item">
                    <a class="nav-link" href="/site/src/profil.php">Mon Profil</a>
                    </li>';

                    echo '<li class="nav-item">
                    <a class="nav-link" href="/site/functions/logout.php">Déconnexion</a>
                </li>';


                } else {
                    echo '<li class="nav-item">
                    <a class="nav-link" href="/site/src/login.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/site/src/register.php">Inscription</a>
                </li>';
                }


                ?>
            </ul>
        </div>
    </div>
</nav>