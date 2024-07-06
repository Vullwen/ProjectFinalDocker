<?php

require_once __DIR__ . "/conf.inc.php";
function connectDB()
{
	try {
		$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);
	} catch (Exception $e) {
		die("Erreur SQL " . $e->getMessage());
	}

	return $connection;
}