<?php 
include('database/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Recipe Category - Inventory IntelliKitchen System</title>
    <?php include('partials/app_header_scripts.php') ?>
    <!-- Style CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <div class="logo">
            <i class="bx bx-menu menu-icon"></i>
            <span class="logo-name">Inventory IntelliKitchen System</span>
        </div>
        <?php include('sidebar.html')?>
    </nav>
    <section id="category">

        <!-- Category Area -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/breakfast.jpg" class="card-img-top" alt="..." style="height: 240px">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>Breakfast Recipes</strong></h5>
                            <a class="btn btn-dark btn-block" data-toggle="modal" data-target="#breakfastModal">View List</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/lunch.jpg" class="card-img-top" alt="..." style="height: 240px">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>Lunch Recipes</strong></h5>
                            <a class="btn btn-dark btn-block" data-toggle="modal" data-target="#lunchModal">View List</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/dinner.jpg" class="card-img-top" alt="..." style="height: 240px">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>Dinner Recipes</strong></h5>
                            <a class="btn btn-dark btn-block" data-toggle="modal" data-target="#dinnerModal">View List</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/appetizer.jpg" class="card-img-top" alt="..." style="height: 240px">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>Appetizer Recipes</strong></h5>
                            <a class="btn btn-dark btn-block" data-toggle="modal" data-target="#appetizerModal">View List</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/dessert.jpeg" class="card-img-top" alt="..." style="height: 240px">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>Dessert Recipes</strong></h5>
                            <a class="btn btn-dark btn-block" data-toggle="modal" data-target="#dessertModal">View List</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/fastfood.jpg" class="card-img-top" alt="..." style="height: 240px">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>Fast Food Recipes</strong></h5>
                            <a class="btn btn-dark btn-block" data-toggle="modal" data-target="#fastFoodModal">View List</a>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        
    </section>

        

<script src="js\jquery\script.js"></script>

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
  
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>



</body>
</html>

<!-- CATEGORY MODALS -->

<!-- Breakfast Modal -->
<div class="modal fade mt-5" id="breakfastModal" tabindex="-1" aria-labelledby="breakfast" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="breakfast"><strong>Breakfast Recipes</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row modal-body">
            
        <?php
        $conn = new mysqli("your_host", "your_username", "your_password", "your_database");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM `tbl_recipe` 
                LEFT JOIN `tbl_category` ON `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                WHERE `category_name` = 'Breakfast'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $recipeID = $row['tbl_recipe_id'];
                $categoryName = $row['category_name'];
                $recipeImage = $row['recipe_image'];
                $recipeName = $row['recipe_name'];
                ?>
                <div class="card" style="width: 185px; height: 200px; margin: 20px">
                    <div class="d-flex justify-content-center align-items-center" style="max-height: 120px;">
                        <img src="http://localhost/my-food-recipe/uploads/<?php echo $recipeImage ?>" class="card-img-top mt-1" alt="Recipe" style="max-width: 120px; max-height: 180px;">
                    </div>
                    <div class="card-body">
                        <h6 class="card-title text-center"><strong><?php echo $recipeName ?></strong></h6>
                        <i class="text-muted">Category: </i><i class="card-subtitle text-muted"><?php echo $categoryName ?></i><br>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "No recipes found.";
        }

        $conn->close();
        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Lunch Modal -->
<div class="modal fade mt-5" id="lunchModal" tabindex="-1" aria-labelledby="lunch" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="lunch"><strong>Lunch Recipes</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row modal-body">
            
        <?php
            $conn = new mysqli("your_host", "your_username", "your_password", "your_database");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM `tbl_recipe` 
                    LEFT JOIN `tbl_category` ON `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                    WHERE `category_name` = 'Lunch'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipeID = $row['tbl_recipe_id'];
                    $categoryName = $row['category_name'];
                    $recipeImage = $row['recipe_image'];
                    $recipeName = $row['recipe_name'];
                    ?>
                    <div class="card" style="width: 185px; height: 200px; margin: 20px">
                        <div class="d-flex justify-content-center align-items-center" style="height: 120px;">
                            <img src="http://localhost/my-food-recipe/uploads/<?php echo $recipeImage ?>" class="card-img-top mt-1" alt="Recipe" style="max-width: 120px; max-height: 180px;">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center"><strong><?php echo $recipeName ?></strong></h6>
                            <i class="text-muted">Category: </i><i class="card-subtitle text-muted"><?php echo $categoryName ?></i><br>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "No recipes found.";
            }

            $conn->close();
        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Dinner Modal -->
    <div class="modal fade mt-5" id="dinnerModal" tabindex="-1" aria-labelledby="dinner" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="dinner"><strong>Dinner Recipes</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row modal-body">
            
        <?php
            $conn = new mysqli("your_host", "your_username", "your_password", "your_database");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM `tbl_recipe` 
                    LEFT JOIN `tbl_category` ON `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                    WHERE `category_name` = 'Dinner'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipeID = $row['tbl_recipe_id'];
                    $categoryName = $row['category_name'];
                    $recipeImage = $row['recipe_image'];
                    $recipeName = $row['recipe_name'];
                    ?>
                    <div class="card" style="width: 185px; height: 200px; margin: 20px">
                        <div class="d-flex justify-content-center align-items-center" style="height: 120px;">
                            <img src="http://localhost/my-food-recipe/uploads/<?php echo $recipeImage ?>" class="card-img-top mt-1" alt="Recipe" style="max-width: 120px; max-height: 180px;">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center"><strong><?php echo $recipeName ?></strong></h6>
                            <i class="text-muted">Category: </i><i class="card-subtitle text-muted"><?php echo $categoryName ?></i><br>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No recipes found.";
            }

            $conn->close();
        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Appetizer Modal -->
<div class="modal fade mt-5" id="appetizerModal" tabindex="-1" aria-labelledby="appetizer" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="appetizer"><strong>Appetizer Recipes</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row modal-body">
            
        <?php
            $conn = new mysqli("your_host", "your_username", "your_password", "your_database");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM `tbl_recipe` 
                    LEFT JOIN `tbl_category` ON `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                    WHERE `category_name` = 'Appetizer'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipeID = $row['tbl_recipe_id'];
                    $categoryName = $row['category_name'];
                    $recipeImage = $row['recipe_image'];
                    $recipeName = $row['recipe_name'];
                    ?>
                    <div class="card" style="width: 200px; height: 185px; margin: 20px">
                        <div class="d-flex justify-content-center align-items-center" style="height: 120px;">
                            <img src="http://localhost/my-food-recipe/uploads/<?php echo $recipeImage ?>" class="card-img-top mt-1" alt="Recipe" style="max-width: 120px; max-height: 180px;">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center"><strong><?php echo $recipeName ?></strong></h6>
                            <i class="text-muted">Category: </i><i class="card-subtitle text-muted"><?php echo $categoryName ?></i><br>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No recipes found.";
            }

            $conn->close();
        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Dessert Modal -->
<div class="modal fade mt-5" id="dessertModal" tabindex="-1" aria-labelledby="dessert" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="dessert"><strong>Dessert Recipes</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row modal-body">
            
        <?php
            $conn = new mysqli("your_host", "your_username", "your_password", "your_database");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM `tbl_recipe` 
                    LEFT JOIN `tbl_category` ON `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                    WHERE `category_name` = 'Appetizer'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipeID = $row['tbl_recipe_id'];
                    $categoryName = $row['category_name'];
                    $recipeImage = $row['recipe_image'];
                    $recipeName = $row['recipe_name'];
                    ?>
                    <div class="card" style="width: 200px; height: 185px; margin: 20px">
                        <div class="d-flex justify-content-center align-items-center" style="height: 120px;">
                            <img src="http://localhost/my-food-recipe/uploads/<?php echo $recipeImage ?>" class="card-img-top mt-1" alt="Recipe" style="max-width: 120px; max-height: 180px;">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center"><strong><?php echo $recipeName ?></strong></h6>
                            <i class="text-muted">Category: </i><i class="card-subtitle text-muted"><?php echo $categoryName ?></i><br>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No recipes found.";
            }

            $conn->close();
        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Fast Food Modal -->
<div class="modal fade mt-5" id="fastFoodModal" tabindex="-1" aria-labelledby="fastFood" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="fastFood"><strong>Fast Food Recipes</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row modal-body">
            
        <?php
            $conn = new mysqli("your_host", "your_username", "your_password", "your_database");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT * FROM `tbl_recipe` 
                    LEFT JOIN `tbl_category` ON `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id` 
                    WHERE `category_name` = 'Appetizer'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipeID = $row['tbl_recipe_id'];
                    $categoryName = $row['category_name'];
                    $recipeImage = $row['recipe_image'];
                    $recipeName = $row['recipe_name'];
                    ?>
                    <div class="card" style="width: 200px; height: 185px; margin: 20px">
                        <div class="d-flex justify-content-center align-items-center" style="height: 120px;">
                            <img src="http://localhost/my-food-recipe/uploads/<?php echo $recipeImage ?>" class="card-img-top mt-1" alt="Recipe" style="max-width: 120px; max-height: 180px;">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center"><strong><?php echo $recipeName ?></strong></h6>
                            <i class="text-muted">Category: </i><i class="card-subtitle text-muted"><?php echo $categoryName ?></i><br>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No recipes found.";
            }

            $conn->close();
        ?>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>