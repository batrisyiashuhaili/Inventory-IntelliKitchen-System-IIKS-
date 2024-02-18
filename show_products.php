<?php
// session_start();
if (!isset($_SESSION['user'])) header('location: login.php');

include('connection.php');

$table_name = $_SESSION['table'];


// Assuming $conn is your MySQLi connection object
$conn = new mysqli("localhost", "root", "", "iiks");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM $table_name ORDER BY exp_date ASC";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in SQL query: " . $conn->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection
$conn->close();

return $data;
