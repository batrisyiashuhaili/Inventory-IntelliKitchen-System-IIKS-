<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iiks";
    
    $conn = mysqli_connect("localhost", "root", "", "iiks");
        
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
