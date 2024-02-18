<?php
session_start();

    // Process form data
    $productName = $_POST['item_name'];
    $expiryDate = $_POST['exp_date'];

    // Save to database
    $sql = "INSERT INTO items (item_name, exp_date) VALUES ('$productName', '$expiryDate')";

    if ($conn->query($sql) === TRUE) {
        echo "Expiry date set successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
