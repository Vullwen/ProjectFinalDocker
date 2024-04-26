<?php

function isAdmin()
{
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
        return false;
    }
    return true;
}