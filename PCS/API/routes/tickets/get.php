<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "database/connectDB.php";
include_once "database/conf.inc.php";

$pdo = connectDB();

$query = "SELECT * FROM tickets";
$stmt = $pdo->prepare($query);
$stmt->execute();

$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

http_response_code(200);
echo json_encode(['success' => true, 'data' => $tickets]);
