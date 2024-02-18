<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iiks";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deductions = $_POST['deductions'];

    foreach ($deductions as $itemId) {
        // Perform deduction logic and update the database
        $sql = "UPDATE items SET item_quantity = item_quantity - 1 WHERE id = $itemId";

        if ($conn->query($sql) === TRUE) {
            // Deduction successful
            echo "Deduction successful!";
        } else {
            // Handle the error
            echo "Error updating record: " . $conn->error;
        }
    }
}

$conn->close();

