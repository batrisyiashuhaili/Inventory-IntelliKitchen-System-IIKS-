<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //retrieve form data
    $email = $_POST['username'];
    $password = $_POST['password'];

    //database connection
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "iiks";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }
    
    // validate login authentication
    $query = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = mysqli_fetch_array($result);

        // Captures data of currently logged-in users.
        $_SESSION['user'] = $email;

        header("Location: dashboard.php");
    } else {
        // Display Bootstrap alert for invalid credentials
        $errorMessage = "Invalid credentials";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory IntelliKitchen System</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body id="loginBody">
    
    <div class="wrapper">
        <form action="login.php"  method="POST">
            <h1>Inventory IntelliKitchen System</h1>
            <h2>Login</h2>
            <?php
            // Display error message if present
            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
            }
            ?>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" placeholder="Password" name="password" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <!-- <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
            </div> -->

            
            <button type="submit" class="btn" >Login</button>
    

            <div class="register-link">
                <p>Don't have an account? <a href="">Register</a></p>
            </div>
        </form>
    </div>
    <?php include('partials/app_scripts.php')?>
</body>
</html>