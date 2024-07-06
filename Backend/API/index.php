<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once "libraries/method.php";
require_once "libraries/path.php";


if (isPath("/api/user")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/user/post.php";
        die();
    }

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/user/get.php";
        die();
    }
}

if (isPath("/api/user/login")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/user/logUser.php";
        die();
    }
}

if (isPath("/api/biens")) {
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

if (isPath("/api/biens/listeBiensProprietaires")) {
    if (isGetMethod() && isset($_GET['id'])) {
        require_once __DIR__ . "/routes/biens/getIDBailleurs.php";
        die();
    }
}

if (isPath("/api/biens/reservations")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getReservations.php";
        die();
    }
}
if (isPath("/api/biens/reservationsCalendar")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getReservationsBiens.php";
        die();
    }
}

if (isPath("/api/user/bailleurs")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/user/getBailleurs.php";
        die();
    }
}

if (isPath("/api/routes/demandebiens")) {
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

if (isPath("/api/user/id")) {
    if (isGetMethod() && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
        require_once __DIR__ . "/routes/user/getId.php";
        die();
    }
}



if (isPath("/api/tickets")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/tickets/post.php";
        die();
    }

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/tickets/get.php";
        die();
    }
}

if (isPath("/api/prestataires/demandes")) {

    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestataires/demandes/get.php";
        die();
    }
}

if (isPath("/api/payment")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/payment.php";
        die();
    }
}

if (isPath("/api/reservation")) {
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

if (isPath("/api/reservation/details")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/getReservationsDetails.php";
        die();
    }
}

if (isPath("/api/biens/disponibilite")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/disponibilite/get.php";
        die();
    }

}

if (isPath("/api/prestataires")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/prestataires/get.php";
        die();
    }
}

if (isPath("/api/demandesBiens/photos")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/biens/photos/getPhotos.php";
        die();
    }
}

if (isPath("/api/biens/photos")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/biens/photos/delete.php";
        die();
    }
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/biens/photos/post.php";
        die();
    }
}

if (isPath("/api/user/update")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/user/update.php";
        die();
    }

}


// PowerPoint soutenance PA : Présentation personnes, présentation du projet, présentation des technologies utilisées. 5 min