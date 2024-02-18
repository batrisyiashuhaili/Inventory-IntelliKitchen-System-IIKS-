<?php

// Include the connection file
include('connection.php');

$data = $_POST;
$id = (int)$data['pid'];  // Ensure 'pid' is the correct key based on your form data
$item_name = $data['item_name'];
$item_quantity = $data['item_quantity'];
$item_category = $data['item_category'];
$exp_date = $data['exp_date'];

// Check if an image file is uploaded
if ($_FILES['img']['error'] == 0) {
    $img = $_FILES['img']['name'];
    $img_path = 'uploads/products/' . $img;
    move_uploaded_file($_FILES['img']['tmp_name'], $img_path);
} else {
    // Use the existing image if no new image is uploaded
    $img = $data['existing_img'];
}

// Prepare and execute the UPDATE query
$command = $conn->prepare("UPDATE items SET item_name=?, item_quantity=?, item_category=?, exp_date=?, img=? WHERE id=?");
$command->bind_param('sss', $item_name, $item_quantity, $item_category, $exp_date, $img, $id);

// Update the record
try {
    $command->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Product updated successfully.',
    ]);
} catch (mysqli_sql_exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error updating the product.',
    ]);
}

$command->close();
$conn->close();
