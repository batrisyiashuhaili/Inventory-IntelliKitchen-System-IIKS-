<?php
// session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

include('connection.php');

$table_name = $_SESSION['table'];


// Assuming $conn is your PDO object
$conn = new PDO("mysql:host=localhost;dbname=iiks", "root", "");

$stmt = $conn->prepare("SELECT * FROM $table_name ORDER BY created_at DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

return $stmt->fetchAll();
