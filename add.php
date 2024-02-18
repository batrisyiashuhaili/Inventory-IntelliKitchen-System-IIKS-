<?php
    // Start the session
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    // Capture the table mappings
    include('table_columns.php');

    // Capture the table name
    $table_name = $_SESSION['table'];
    $columns = $table_columns_mapping[$table_name];

    // PHP to insert a new product
    $expiryDate = $_POST['exp_date'];

    // Loop through the columns
    $db_arr = [];

    foreach ($columns as $column) {
        if (in_array($column, ['exp_date'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve the value of the "exp_date" input from the form
                $expiryDate = $_POST['exp_date'];
    
                // Check if the value is empty or invalid
                if (!empty($expiryDate) && strtotime($expiryDate)) {
                    // Format the date without time
                    $value = date('Y-m-d', strtotime($expiryDate));
                } else {
                    // If the value is empty or invalid, set it to null
                    $value = null;
                }
    
                } else {
                    // Handle other HTTP methods or redirect if needed
                    $value = null;
                }
        } else if ($column == 'password') {
            $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
        } else if ($column == 'img') {
            // Use null coalescing operator to handle undefined 'img' key
            $file_data = $_FILES[$column] ?? null;

            if ($file_data) {
                // Upload or move the file to our directory
                $target_dir = "../uploads/products/";
                $file_name = $file_data['name'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $file_name = 'product-' . time() . '.' . $file_ext;

                $check = getimagesize($file_data['tmp_name']);

                // Move the file
                if (move_uploaded_file($file_data['tmp_name'], $target_dir . $file_name)) {
                    // Save the file_name to the database
                    $value = $file_name;
                }
            } else {
                // 'img' key is not present in $_FILES array
                // Handle the case accordingly
                $value = null;
            }
        } else {
            $value = $_POST[$column] ?? '';
        }

        $db_arr[$column] = $value;
    }

    $table_properties = implode(", ", array_keys($db_arr));
    $table_placeholders = rtrim(str_repeat('?, ', count($columns)), ', ');

    // Adding the record.
    try {
        $sql = "INSERT INTO $table_name ($table_properties) 
            VALUES ($table_placeholders)";

        include('connection.php');

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Error in preparing statement");
        }

        // Prepare an array of values for binding
        $values = array_values($db_arr);

        // Bind the parameters
        $bindTypes = str_repeat('s', count($db_arr)); // Assuming all values are strings; adjust accordingly

        // Use call_user_func_array to pass the values as separate arguments
        call_user_func_array([$stmt, 'bind_param'], array_merge([$bindTypes], $values));

        $stmt->execute();

        $response = [
            'success' => true,
            'message' => 'Successfully added to the system.'
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }

    $_SESSION['response'] = $response;
    header('Location: ../' . $_SESSION['redirect-to']);
    exit();
