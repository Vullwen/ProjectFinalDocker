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
        require_once __DIR__ . "/routes/user/logUser.php";
        die();
    }
}
