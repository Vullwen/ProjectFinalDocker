<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once "libraries/method.php";
require_once "libraries/path.php";


if (isPath("PCS/API/register")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/user/post.php";
        die();
    }
}