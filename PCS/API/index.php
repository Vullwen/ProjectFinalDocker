<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once "libraries/method.php";
require_once "libraries/path.php";


if (isPath("/2A-ProjetAnnuel/PCS/API/user")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/user/post.php";
        die();
    }

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/user/get.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/user/login")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/user/logUser.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/biens")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/biens/post.php";
        die();
    }

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/get.php";
        die();
    }

    if (isDeleteMethod()) {
        if (isset($_GET['id'])) {
            require_once __DIR__ . "/routes/biens/delete.php=id={$_GET['id']}";
            die();
        }
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/biens/patch.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/biens/listeBiensProprietaires")) {
    if (isGetMethod() && isset($_GET['id'])) {
        require_once __DIR__ . "/routes/biens/getIDBailleurs.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/biens/reservations")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getReservations.php";
        die();
    }
}
if (isPath("/2A-ProjetAnnuel/PCS/API/biens/reservationsCalendar")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getReservationsBiens.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/user/bailleurs")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/user/getBailleurs.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/routes/demandebiens")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/biens/demandes/post.php";
        die();
    } else if (isGetMethod()) {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            require_once __DIR__ . "/routes/biens/demandes/getID.php";
        } else {
            require_once __DIR__ . "/routes/biens/demandes/get.php";
        }
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/user/id")) {
    if (isGetMethod() && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
        require_once __DIR__ . "/routes/user/getId.php";
        die();
    }
}



if (isPath("/2A-ProjetAnnuel/PCS/API/tickets")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/tickets/post.php";
        die();
    }

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/tickets/get.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/prestataires/demandes")) {

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestataires/demandes/get.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/payment")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/payment.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/reservation")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/reservation/post.php";
        die();
    }

    if (isGetMethod() && isset($_GET['id'])) {
        require_once __DIR__ . "/routes/reservation/get.php";
        die();
    }

    if (isDeleteMethod() && isset($_GET['id'])) {
        require_once __DIR__ . "/routes/reservation/delete.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/reservation/details")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getReservationsDetails.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/biens/disponibilite")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/disponibilite/get.php";
        die();
    }

}

if (isPath("/2A-ProjetAnnuel/PCS/API/prestataires")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestataires/get.php";
        die();
    }
}

if (isPath("/2A-ProjetAnnuel/PCS/API/demandesBiens/photos")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getPhotos.php";
        die();
    }
}


// PowerPoint soutenance PA : Présentation personnes, présentation du projet, présentation des technologies utilisées. 5 min