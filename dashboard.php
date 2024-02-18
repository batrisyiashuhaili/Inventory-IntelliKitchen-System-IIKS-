<?php
session_start();
    if(!isset($_SESSION['user'])) header('locaion: login.php');

    $_SESSION['table'] = 'items';
    $products = include('database/show_products.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory IntelliKitchen System</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" type="text/css" href="style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="body1">
    <nav>
        <?php 
            include('sidebar.html');
            include('database/show_products.php');
        ?>
        <div class="row">
            <div class="col-6 logo">
                <i class="bx bx-menu menu-icon"></i>
                <span class="logo-name">Inventory IntelliKitchen System</span>
            </div>
            <div class="col-6 logo">
                <span class="logo-date" id="datetime"></span>
            </div>
        </div>

    </nav>

    <div class="container">
        <!-- Main Content -->
        <main >
        <?php 
        //connect with database
        include 'database/connection.php'; ?>
            <h1>Dashboard</h1>
                <!-- Dashboard -->
                <div class="analyse" id="analyse">
                    <div class="sales">
                        <div class="status">
                            <div class="info">
                                <h3>Total Items</h3>
                                <?php
                                $dash_items_query = "SELECT * FROM items";
                                $dash_items_query_run = mysqli_query($conn, $dash_items_query);

                                if($items_total= mysqli_num_rows($dash_items_query_run)){

                                    echo '<h1 class = "ab-0">'.$items_total.'</h1>';

                                }
                                else{
                                    echo '<h1 class = "ab-0">No data</h1>';
                                }

                                ?>

                            </div>
                            <i class='bx bxs-box'></i>
                        </div>
                    </div>
                    
                    <div class="searches">
                        <div class="status">
                            <div class="info">
                                <h3>Expired Date Items</h3>
                                <?php
                                // Assuming you want the current date in the format 'Y-m-d'
                                $currentDate = date('Y-m-d');

                                $dash_expired_query = "SELECT * FROM items WHERE exp_date < '$currentDate'";
                                $dash_expired_query_run = mysqli_query($conn, $dash_expired_query);

                                if($expired_total= mysqli_num_rows($dash_expired_query_run)){

                                    echo '<h1 class = "ab-0">'.$expired_total.'</h1>';

                                }
                                else{
                                    echo '<h1 class = "ab-0">No data</h1>';
                                }

                                ?>
                            </div>
                            <i class='bx bxs-calendar-x'></i>
                        </div>
                    </div>
                </div>  
            <!--End of Analyse-->

        <!--Recent orders table-->
        <div class="recent-orders">
            <h2>Expired Products</h2>
            <table>
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Product Quantity</th>
                    <th>Expiry Date</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    $count = 0;
                    foreach($products as $index => $product){
                        // Check if the expiration date has passed
                        $currentDate = date('Y-m-d');
                        $expirationDate = $product['exp_date'];
                        
                        if ($expirationDate < $currentDate) {?>
                            <tr>
                                <td><?= $index + 1?></td>
                                <td class="firstName">
                                    <img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt=""/>    
                                </td>
                                <td class="productName"><?= $product['item_name']?></td>
                                <td class="productQuantity"><?= $product['item_quantity']?></td>
                                <td><?= date('M d,Y', strtotime($product['exp_date']))?></td>
                            </tr>
                <?php
                            $count++;
                        }
                    }
                    
                    // Check if there are no expired items
                    if ($count === 0) {
                        echo '<tr><td colspan="5">No expired items found.</td></tr>';
                    }?>
                    
                    
                </tbody>
            </table>
        </div>
        <!--End of Recent Orders -->
        </main>

        
    </div>

    <section class="overlay"></section>

    <script src="js\jquery\script.js"></script>
    <script src="js/jquery/jquery-3.7.1.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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


      // create a function to update the date and time
      function updateDateTime() {
        // create a new `Date` object
        const now = new Date();

        // get the current date and time as a string
        const currentDateTime = now.toLocaleString();

        // update the `textContent` property of the `span` element with the `id` of `datetime`
        document.querySelector('#datetime').textContent = currentDateTime;
      }

      // call the `updateDateTime` function every second
      setInterval(updateDateTime, 1000);
    </script>
</body>
</html>