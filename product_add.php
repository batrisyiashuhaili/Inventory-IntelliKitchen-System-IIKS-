<?php
    // Start the session
    session_start();
    if(!isset($_SESSION['user'])) header('loction: login.php');

    $_SESSION['table'] = 'items';
    $_SESSION['redirect-to'] = 'product_add.php';

    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Products - Inventory IntelliKitchen System</title> 
    <?php include('partials/app_header_scripts.php') ?> 
</head>

<body>
    <nav>
        <div class="logo">
            <i class="bx bx-menu menu-icon"></i>
            <span class="logo-name">Inventory IntelliKitchen System</span>
        </div>
        <?php 
        include('sidebar.html');
        include('database/show_products.php');
        ?>
    </nav>
    <div class="dashboard_content">
        <div class="dashboard_content_main">
                <h1 class="section_header"><i class='bx bx-plus-medical' ></i> Add Products</h1>
                    <div id="userAddFormContainer">

                        <form method="post" action="database/add.php" class="appForm" id="productAddForm" enctype="multipart/form-data">
                            <div class="appFormInputContainer">
                                <label for="item_name">Product Name</label>
                                <input type="text" class="appFormInput" id="item_name" placeholder="Enter product name..." name="item_name" required/>
                            </div>
                            <div class="appFormInputContainer">
                                <label for="item_quantity">Product Quantity</label>
                                <input type="text" class="appFormInput" id="item_quantity" placeholder="Enter number only..." name="item_quantity" required/>
                            </div>
                            <div class="appFormInputContainer">
                                <label for="item_category">Product Category</label>
                                <br>
                                
                                <label for="dryFoods">Dry Food</label>
                                <input type="radio" class="appFormInput" id="dryFoods" name="item_category" value="Dry Foods" required />
                                
                                <label for="wetIngredients">Wet Ingredients</label>
                                <input type="radio" class="appFormInput" id="wetIngredients" name="item_category" value="Wet Ingredients" required />
                            </div>
                            <div class="appFormInputContainer">
                                <label for="exp_date">Expiry Date</label>
                                <input type="date" class="appFormInput" id="exp_date" name="exp_date" required />
                            </div>
                            <div class="appFormInputContainer">
                                <label for="img">Product Image</label>
                                <input type="file" class="appFormInput" id="img" name="img" required/>
                            </div>

                            <button type="submit" class="appBtn"><i class='bx bx-plus-medical' ></i> Add Product</button>
                        </form>

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


    
    
    <?php include('partials/app_scripts.php') ?>
    <!-- <script>
    
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
        
</script> -->
  
</body>
</html>