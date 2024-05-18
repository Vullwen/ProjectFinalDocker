<?php

function estBailleur()
{
    if (!isset($_SESSION['estBailleur']) || $_SESSION['estBailleur'] != 1) {
        return false;
    }
    return true;
}