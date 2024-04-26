<?php
session_start();
session_destroy();
header("Location: /2A-ProjetAnnuel/PCS/Site/src/login.php");