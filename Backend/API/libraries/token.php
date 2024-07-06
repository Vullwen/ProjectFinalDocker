<?php
function getAuthenticationToken(): string
{
    return bin2hex(random_bytes(16));
}
