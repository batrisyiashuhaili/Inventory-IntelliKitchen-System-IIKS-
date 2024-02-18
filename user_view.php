<?php
// include("database/connection.php");
session_start();
    if(!isset($_SESSION['user'])) header('locaion: login.php');

    $_SESSION['table'] = 'users';
    $users = include('database/show_users.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Users - Inventory IntelliKitchen System</title>
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
        include('database/show_users.php');
        ?>
    </nav>
    <div class="dashboard_content">
        <div class="dashboard_content_main">
            <div class="row">
                <div class="column column-12">
                    <h1 class="section_header"><i class='bx bx-list-ul'></i> List of Users</h1>
                    <div class="section_content">
                        <div class="users">
                            <table>
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($users as $index => $user){ ?>
                                            <tr>
                                                <td><?= $index + 1?></td>
                                                <td class="firstName"><?= $user['first_name']?></td>
                                                <td class="lastName"><?= $user['last_name']?></td>
                                                <td class="email"><?= $user['email']?></td>
                                                <td><?= $user['user_type']?></td>
                                                <td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at']))?></td>
                                                <td><?= date('M d,Y @ h:i:s A', strtotime($user['updated_at']))?></td>
                                                <td>
                                                    <a href="" class="updateUser"data-userid="<?= $user['id'] ?>"><i class='bx bx-edit-alt'></i> Edit</a>
                                                    <a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>" ><i class='bx bx-trash'></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    
                                    
                                </tbody>
                            </table>
                            <p class="userCount"><?= count($users) ?> Users</p>
                        </div>
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
        
        function script(){

            this.registerEvents = function(){
                document.addEventListener('click', function(e){
                    targetElement = e.target;
                    classList = targetElement.classList;


                    if(classList.contains('deleteUser')){
                        e.preventDefault();
                        pId = targetElement.dataset.userid;
                        fname = targetElement.dataset.fname;
                        lname = targetElement.dataset.lname;
                        fullName = fname + ' ' + lname;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete User',
                            message: 'Are you sure to delete <strong>' + fullName +'</strong> ?',
                            callback: function(isDelete){
                                if(isDelete){
                                    $.ajax({
                                    method: 'POST',
                                    data: {
                                        id: pId,
                                        table: 'users'
                                        },
                                    url:'database/delete.php',
                                    dataType: 'json',
                                    success: function(data){
                                        message = data.success ?
                                            fullName = ' sucessfully deleted!' : 'Error prcessing your request!';

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
                        });
                    }

                    if(classList.contains('updateUser')){
                        e.preventDefault(); // Prevent from loading
                        
                        //Get data
                        firstName = targetElement.closest('tr').querySelector('td.firstName').innerHTML;
                        lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
                        email = targetElement.closest('tr').querySelector('td.email').innerHTML;
                        userId = targetElement.dataset.userid;

                        BootstrapDialog.confirm({
                            title: 'Update ' + firstName + ' ' + lastName,
                            message: '<form>\
                                <div class="form-group">\
                                    <label for="firstName">First Name:</label>\
                                    <input type="text" class="form-control" id="firstName" value="'+ firstName +'">\
                                </div>\
                                <div class="form-group">\
                                    <label for="lastName">Last Name:</label>\
                                    <input type="text" class="form-control" id="lastName" value="'+ lastName +'">\
                                </div>\
                                <div class="form-group">\
                                    <label for="email">Email address:</label>\
                                    <input type="email" class="form-control" id="emailUpdate" value="'+ email +'">\
                                </div>\
                            </form>',
                            callback: function(isUpdate){
                                if(isUpdate){ // If user click 'OK' button
                                    $.ajax({   
                                        method: 'POST',
                                        data: {
                                            userId: userId,
                                            f_name: document.getElementById('firstName').value,
                                            l_name: document.getElementById('lastName').value,
                                            email: document.getElementById('emailUpdate').value,

                                        },
                                        url:'database/update_user.php',
                                        dataType: 'json',
                                        success: function(data){
                                            if(data.success){
                                                BootstrapDialog.alert({
                                                    type: BootstrapDialog.TYPE_SUCCESS,
                                                    message: data.message,
                                                    callback: function(){
                                                        location.reload();
                                                    }
                                                });
                                            }else 
                                                BootstrapDialog.alert({
                                                type: BootstrapDialog.TYPE_SUCCESS,
                                                });
                                        }                              
                                    });
                                }
                            }
                    
                        });
                    }
                });
            }
            
            this.initilaize = function(){
                this.registerEvents();
            }
        }

        var script = new script;
        script.initilaize();
    </script>
</body>
</html>