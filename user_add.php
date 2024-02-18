<?php
session_start();
    if(!isset($_SESSION['user'])) header('loction: login.php');

    $_SESSION['table'] = 'users';
    $_SESSION['redirect-to'] = 'user_add.php';

    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Users - Inventory IntelliKitchen System</title>
    <?php include('partials/app_header_scripts.php') ?>
</head>

<body>
    <nav>
        <div class="logo">
            <i class="bx bx-menu menu-icon"></i>
            <span class="logo-name">Inventory IntelliKitchen System</span>
        </div>
        <?php 
        //include('sidebar.html');
        include('database/show_users.php');
        ?>
    </nav>
    <div class="dashboard_content">
        <div class="dashboard_content_main">
            <div class="row">
                <div class="column column-12">
                    <h1 class="section_header"><i class='bx bx-plus-medical' ></i> Create User</h1>
                        <div id="userAddFormContainer">

                            <form action="database/add.php" method="POST" class="appForm" id="userAddForm">
                                <div class="appFormInputContainer">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="appFormInput" id="first_name" name="first_name" required/>
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="appFormInput" id="last_name" name="last_name" required/>
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="email">Email</label>
                                    <input type="email" class="appFormInput" id="email" name="email" required/>
                                </div>
                                <div class="appFormInputContainer">
                                    <label for="password">Password</label>
                                    <input type="password" class="appFormInput" id="password" name="password" required/>
                                </div>
                                <div class="appFormInputContainer">
                                    <label>User Type</label> <br>
                                    <label for="admin">Admin</label>
                                    <input type="radio" class="appFormInput" id="admin" name="user_type" value="admin" required/>
                                    <label for="userr">User</label>
                                    <input type="radio" class="appFormInput" id="userr" name="user_type" value="user" required/>
                                </div>

                                <button type="submit" class="appBtn"><i class='bx bx-plus-medical' ></i> Add User</button>
                                
                            </form>
                            <a href="login.php" class="appBtn"><i class='bx bx-log-in'></i> Login</a>

                            <?php
                                if(isset($_SESSION['response'])) {
                                    $response_message = $_SESSION['response']['message'];
                                    $is_success = $_SESSION['response']['success'];
                            ?>
                            <div class="responseMessage">
                                <p class="responseMessage <?=$is_success ? 'responseMessage_success' : 'responseMessage_error'?>">
                                    <?=$response_message?>         
                                </p>
                            </div>
                            <?php unset($_SESSION['response']); } ?>
                        </div>
                </div>
            
            </div>
        </div>
    </div>
    <?php include('partials/app_scripts.php');
    include('database/show_users.php');?>
<script>
    const navBar = document.querySelector("nav"),
        menuBtns = document.querySelectorAll(".menu-icon"),
        overlay = document.querySelector(".overlay");

        menuBtns.forEach((menuBtn) => {
            menuBtn.addEventListener("click", () => {
                navBar.classList.toggle("open");
            });
        });

        overlay.addEventListener("click", () => {
            navBar.classList.remove("open");
        })
</script>
</body>
</html>