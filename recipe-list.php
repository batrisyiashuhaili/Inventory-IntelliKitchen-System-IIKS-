<?php 
include('database\connection.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Recipe List - Inventory IntelliKitchen System</title>
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
        ?>
    </nav>
    <section id="food">
        <div class="card card-food-list">
            <h1 class="text-center"><strong>Recipe Lists</strong></h1>
            <div class="mt-4">
                <div class="row">
                    <div class="col-md-2 mr-auto">
                        <button type="button" class="btn btn-add-food btn-secondary" data-toggle="modal" data-target="#addRecipeModal">Add Recipe</button>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control p-4" type="text" id="searchInput" placeholder="Search...">
                    </div>
                </div>
            </div>

            
            <table id="foodListTable" class="table table-responsive mt-4" style="text-align:center;">
                <thead>
                    <tr>
                    <th scope="col" style="width: 5%;">Food ID</th>
                    <th scope="col" style="width: 10%;">Recipe Image</th>
                    <th scope="col" style="width: 10%;">Recipe Name</th>
                    <th scope="col" style="width: 10%;">Category</th>
                    <th scope="col" style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $conn = new mysqli("localhost", "root", "", "iiks");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $query = "
                    SELECT * 
                    FROM 
                        `tbl_recipe`
                    LEFT JOIN
                        `tbl_category` ON
                        `tbl_recipe`.`tbl_category_id` = `tbl_category`.`tbl_category_id`
                ";

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $recipeID = $row['tbl_recipe_id'];
                        $categoryID = $row['tbl_category_id'];
                        $categoryName = $row['category_name'];
                        $recipeImage = $row['recipe_image'];
                        $recipeName = $row['recipe_name'];
                        $recipeIngredients = $row['recipe_ingredients'];
                        $recipeProcedure = $row['recipe_procedure'];
                        ?>

                        <tr>
                            <th id="recipeID-<?php echo $recipeID ?>"><?php echo $recipeID ?></th>
                            <td id="recipeImage-<?php echo $recipeID ?>"><img src="./uploads/<?php echo $recipeImage ?>" class="img-fluid" style="height: 50px; width: 90px" alt="Recipe Image"></td>
                            <td id="recipeName-<?php echo $recipeID ?>"><?php echo $recipeName ?></td>
                            <td id="categoryName-<?php echo $recipeID ?>"><?php echo $categoryName ?></td>
                            <td id="recipeIngredients-<?php echo $recipeID ?>" hidden><?php echo $recipeIngredients ?></td>
                            <td id="recipeProcedure-<?php echo $recipeID ?>" hidden><?php echo $recipeProcedure ?></td>
                            
                            <td>
                                <button type="button" onclick="view_recipe('<?php echo $recipeID ?>')" title="View"><i class='bx bx-list-ul p-1'></i></button>
                                <button type="button" onclick="update_recipe('<?php echo $recipeID ?>')" title="Edit"><i class='bx bxs-pencil p-1' ></i></button>
                                <button type="button" onclick="delete_recipe('<?php echo $recipeID ?>')" title="Delete"><i class='bx bxs-trash-alt p-1' ></i></button>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo '<tr><td colspan="7">No data</td></tr>';
                }

                $conn->close();
                ?>
                    
                </tbody>
            </table>
        </div>

    </section>

        
<!-- FOOD LISTS MODALS -->

 <!-- Add Recipe Modal -->
 <div class="modal fade mt-5" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipe" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecipe"><strong>Add Recipe</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="recipeID" action="database/add-recipe.php" method="POST" enctype="multipart/form-data">
                    <input type="text" class="form-control" id="table" name="table" value="tbl_recipe" hidden>
                    <div class="mb-3" hidden>
                        <label for="recipeID" class="form-label">Recipe ID</label>
                        <input type="text" class="form-control" id="recipeID" name="tbl_recipe_id">
                    </div>
                    <div class="mb-3">
                        <label for="recipeImage" class="form-label">Recipe Image</label>
                        <input type="file" class="form-control" id="recipeImage" name="recipe_image" style="border:none;">
                    </div>
                    <div class="mb-3">
                        <label for="recipeName" class="form-label">Recipe Name</label>
                        <input type="text" class="form-control" id="recipeName" name="recipe_name">
                    </div>
                    <div class="mb-3">
                        <label for="recipeCategory" class="form-label">Category</label>

                        <?php
                        $conn = new mysqli("localhost", "root", "", "iiks");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $query = "SELECT * FROM `tbl_category`";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            $recipe_category = $result->fetch_all(MYSQLI_ASSOC);
                        } else {
                            $recipe_category = array();
                        }

                        $conn->close();
                        ?>

                        <select class="form-control" name="tbl_category_id" id="recipeCategory">

                            <option value="">- select -</option>
                            
                            <?php foreach ($recipe_category as $category) {
                                ?>
                                
                                <option value="<?php echo $category['tbl_category_id']; ?>"><?php echo $category['category_name'] ?></option>
                                
                                <?php    
                            }?>

                        </select>

                    </div>
                    <div>
                        <label for="recipeIngredients" class="form-label">Ingredients</label>
                        <textarea class="form-control" name="recipe_ingredients" id="recipeIngredients" rows="5"></textarea>
                    </div>
                    <div>
                        <label for="recipeProcedure" class="form-label">Procedure</label>
                        <textarea class="form-control" name="recipe_procedure" id="recipeProcedure" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Recipe Modal -->
<div class="modal fade mt-5" id="viewRecipeModal" tabindex="-1" aria-labelledby="viewRecipe" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="viewRecipe"><strong>My Recipe</strong></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

        <div class="card">
            <div class="d-flex justify-content-center align-items-center">
                <img src="" id="viewRecipeImage" class="card-img-top mt-2" alt="Recipe" style="max-width: 300px">
            </div>
            <div class="card-body text-center">
                <h6 class="card-title"><strong id="viewRecipeName"></strong></h6>
                <p class="text-muted">Category: <span class="card-subtitle text-muted" id="viewCategoryName"></span></p>
            </div>
            <div class="row text-center mb-5 p-3">
                <div class="col">
                    <h5><strong>Ingredients:</strong></h5>
                    <p id="viewRecipeIngredients"></p>
                </div>
                <div class="col">
                    <h5><strong>Procedure:</strong></h5>
                    <p id="viewRecipeProcedure"></p>
                </div>
            </div>
        </div>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark" data-toggle="modal" data-target="#kitchenInventoryModal">Continue</button>
            </div>
            
        </div>
    </div>
</div>

<!-- Kitchen Inventory Modal -->
<div class="modal fade" id="kitchenInventoryModal" tabindex="-1" aria-labelledby="kitchenInventory" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kitchenInventory"><strong>Kitchen Inventory</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="column">
                        <h3>Kitchen Inventory</h3>
                        <table>
                            <!-- Add your dynamic inventory data here -->
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $conn = new mysqli("localhost", "root", "", "iiks");

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $query = "SELECT item_name, item_quantity
                                FROM items
                                WHERE item_quantity != 0;";

                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $productName = $row['item_name'];
                                        $productQuantity = $row['item_quantity'];
                                        ?>

                                        <tr>
                                            <td><input type="checkbox" class="inventory-checkbox" data-item-id="1"></td>
                                            <td id="item_name-<?php echo $productName ?>"><?php echo $productName ?></td>

                                            <td id="item_quantity-<?php echo $productQuantity ?>"><?php echo $productQuantity ?></td>
                                            
                                        </tr>

                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7">No data</td></tr>';
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="column">
                        <h3>Recipe Ingredients</h3>
                        <p id="viewRecipeIngredients"></p>
                        
                        <table>
                            <!-- Add your dynamic recipe ingredient data here -->
                            <thead>
                                <tr>
                                    <th>Ingredient</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <?php
                                $conn = new mysqli("localhost", "root", "", "iiks");

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $recipeIngredients = $row['recipe_ingredients'];
                                        ?>

                                        <tr>
                                            <td id="recipeIngredients-<?php echo $recipeID ?>" hidden><?php echo $recipeIngredients ?></td><td id="recipe_ingredients-<?php echo $recipeIngredients ?>"><?php echo $recipeIngredients ?></td>          
                                        </tr>

                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7">No data</td></tr>';
                                }

                                $conn->close();
                                ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Recipe Modal -->
<div class="modal fade mt-5" id="updateRecipeModal" tabindex="-1" aria-labelledby="updateRecipe" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateRecipe"><strong>Update Recipe</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="recipeID" action="database/update-recipe.php" method="POST" enctype="multipart/form-data">
                    <input type="text" class="form-control" id="updateTable" name="table" value="tbl_recipe" hidden>
                    <div class="mb-3" hidden>
                        <label for="updateRecipeID" class="form-label">Recipe ID</label>
                        <input type="text" class="form-control" id="updateRecipeID" name="tbl_recipe_id">
                    </div>
                    <div class="mb-3">
                        <label for="updateRecipeImage" class="form-label">Recipe Image</label>
                        <input type="file" class="form-control" id="updateRecipeImage" name="recipe_image" style="border:none;">
                    </div>
                    <div class="mb-3">
                        <label for="updateRecipeName" class="form-label">Recipe Name</label>
                        <input type="text" class="form-control" id="updateRecipeName" name="recipe_name">
                    </div>
                    <div class="mb-3">
                        <label for="updateRecipeCategory" class="form-label">Category</label>

                        <?php
                        $conn = new mysqli("localhost", "root", "", "iiks");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $query = "SELECT * FROM `tbl_category`";
                        $result = $conn->query($query);

                        $recipe_category = array();

                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $recipe_category[] = $row;
                            }
                        }

                        $conn->close();
                        ?>

                        <select class="form-control" name="tbl_category_id" id="updateRecipeCategory">

                            <option value="">- select -</option>
                            
                            <?php foreach ($recipe_category as $category) {
                                ?>
                                
                                <option value="<?php echo $category['tbl_category_id']; ?>"><?php echo $category['category_name'] ?></option>
                                
                                <?php    
                            }?>

                        </select>

                    </div>
                    <div>
                        <label for="updateRecipeIngredients" class="form-label">Ingredients</label>
                        <textarea class="form-control" name="recipe_ingredients" id="updateRecipeIngredients" rows="5"></textarea>
                    </div>
                    <div>
                        <label for="updateRecipeProcedure" class="form-label">Procedure</label>
                        <textarea class="form-control" name="recipe_procedure" id="updateRecipeProcedure" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-dark">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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