<?php
// include('../database/connection.php');
session_start();
if (!isset($_SESSION['user'])) {
    //header('location: login.php');
}

    $_SESSION['table'] = 'items';
    $products = include('database/show_products.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Products - Inventory IntelliKitchen System</title>
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
            <div class="row">
                <div class="column column-12">
                    <h1 class="section_header"><i class='bx bx-list-ul'></i> List of Products</h1>
                    <div class="section_content">
                        <div class="users">
                            <table>
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Product Quantity</th>
                                    <th>Product Category</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $count = 0;
                                        foreach($products as $index => $product){ ?>
                                            <tr>
                                                <td><?= $index + 1?></td>
                                                <td class="firstName">
                                                    <img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt=""/>    
                                                </td>
                                                <td class="productName"><?= $product['item_name']?></td>
                                                <td class="productQuantity"><?= $product['item_quantity']?></td>
                                                <td class="productCategory"><?= $product['item_category']?></td>
                                                <td><?= date('M d,Y', strtotime($product['exp_date']))?></td>
                                                <td>
                                                    <a href="#" class="updateProduct" data-pid="<?= $product['id'] ?>"> <i class='bx
                                                     bx-edit-alt'></i> Edit</a> |
                                                    <a href="#" class="deleteProduct" data-name="<?= $product['item_name'] ?>" data-pid="<?= $product['id'] ?>"> <i class='bx
                                                     bx-trash'></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    
                                    
                                </tbody>
                            </table>
                            <p class="userCount"><?= count($products) ?> Products</p>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

    
    <?php 
        include('partials/app_scripts.php');
        include('database/show_products.php');
    ?>
    
<script>
    
    const navBar = document.querySelector("nav"),
            menuBtns = document.querySelectorAll(".menu-icon"),
            overlay = document.querySelector(".overlay");

        menuBtns.forEach((menuBtn) => {
            menuBtn.addEventListener("click", () => {
                navBar.classList.toggle("open");
            });
        });

  
    function script(){
        var vm = this;

        this.registerEvents = function(){
            document.addEventListener('click', function(e){
                targetElement = e.target; // Get the target element
                classList = targetElement.classList; 

                if(classList.contains('deleteProduct')){
                    e.preventDefault(); // This prevents the default mechanism
                    
                    pId = targetElement.dataset.pid;
                    pName = targetElement.dataset.name;

                    BootstrapDialog.confirm({
                        type: BootstrapDialog.TYPE_DANGER,
                        title: 'Delete Product',
                        message: 'Are you sure to delete <strong>' + pName +'</strong>?',
                        callback: function(isDelete){
                            if(isDelete){
                                $.ajax({
                                method: 'POST',
                                data: {
                                    id: pId,
                                    table: 'items'
                                    },
                                url:'database/delete.php',
                                dataType: 'json',
                                success: function(data){
                                    message = data.success ?
                                        pName = ' sucessfully deleted!' : 'Error prcessing your request!';

                                    BootstrapDialog.alert({
                                        type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                        message: message,
                                        callback: function(){
                                            if(data.success) location.reload();
                                        }
                                    });
                                }
                                });
                            } 
                        }
                    })
                    }

                    if(classList.contains('updateProduct')){
                        e.preventDefault(); // This prevents the default mechanism
                    
                        pId = targetElement.dataset.pid;
                        
                        vm.showEditDialog(pId);
                    }
            });

            // document.addEventListener('submit', function(e){
            //     targetElement = e.target; // Target element

            //     alert(targetElement.id);
            //     e.preventDefault();
            // });

            $('#editProductForm').on('submit', function(e){
                e.preventDefault();
            });

            document.addEventListener('submit', function(e){
                e.preventDefault();
                targetElement = e.target;

                if(targetElement.id === 'editProductForm'){
                    vm.saveUpdatedData(targetElement);
                }
            })
        },

        this.saveUpdatedData =function(form){
            $.ajax({   
                method: 'POST',
                data: new FormData(form),
                url:'database/update_product.php',
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data){
                    BootstrapDialog.alert({
                        type: data.success ? BootstrapDialog.TYPE_SUCCESS :BootstrapDialog.TYPE_DANGER,
                        message: data.message,
                        callback:function(){
                            if(data.success) location.reload();
                        }
                    })
                }                              
            });
        }

        this.showEditDialog = function(id){
            $.get('database/get_product.php', {id: id}, function(productDetails){
                console.log(productDetails);  // Add this line to log the productDetails object

                BootstrapDialog.confirm({
                    title: 'Update <strong>' + productDetails.item_name + '</strong>',
                    message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
                        <div class="appFormInputContainer">\
                            <label for="item_name">Product Name</label>\
                            <input type="text" class="appFormInput" id="item_name" value="' + productDetails.item_name + '" placeholder="Enter product name..." name="item_name"/>\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="item_quantity">Product Quantity</label>\
                            <input type="text" class="appFormInput" id="item_quantity" value="' + productDetails.item_quantity + '" placeholder="Enter product quantity..." name="item_quantity"/>\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="item_category">Product Category</label>\
                            <br>\
                            \
                            <label for="dryFoods">Dry Food</label>\
                            <input type="radio" class="appFormInput" id="dryFoods" value="Dry Food" name="item_category" ' + (productDetails.item_category === 'Dry Food' ? 'checked' : '') + '/>\
                            \
                            <label for="wetIngredients">Wet Ingredients</label>\
                            <input type="radio" class="appFormInput" id="wetIngredients" value="Wet Ingredients" name="item_category" ' + (productDetails.item_category === 'Wet Ingredients' ? 'checked' : '') + '/>\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="exp_date">Expiry Date</label>\
                            <input type="date" class="appFormInput" id="exp_date" value="' + productDetails.exp_date + '" name="exp_date required"/>\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="img">Product Image</label>\
                            <input type="file" class="appFormInput" id="img" name="img" />\
                        </div>\
                        <input type="hidden" name="pid" value="'+ productDetails.id+ '"/>\
                        <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
                        </form>\
                        ',
                    callback: function(isUpdate){
                        if(isUpdate){ // If user click 'OK' button

                            document.getElementById('editProductSubmitBtn').click();
                        }
                    }
                });
            }, 'json');

            
        };

        this.initialize = function(){
            this.registerEvents();
        }
    }


    var script = new script;
    script.initialize();
</script>
</body>
</html>