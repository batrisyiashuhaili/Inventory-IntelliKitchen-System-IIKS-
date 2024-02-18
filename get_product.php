<?php
include('connection.php');

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM items WHERE id=$id");
$stmt->execute();
$row = $stmt->fetch();

echo json_encode($row);