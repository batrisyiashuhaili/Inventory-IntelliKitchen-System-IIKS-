<?php
include('connection.php');

if (isset($_GET['recipe'])) {
    $recipeID = $_GET['recipe'];

    // Retrieve the book image filename
    $stmt = $conn->prepare("SELECT `recipe_image` FROM `tbl_recipe` WHERE `tbl_recipe_id` = ?");
    $stmt->execute([$recipeID]);

    // Fetch the result
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($row = $result->fetch_assoc()) {
        $recipeImage = $row['recipe_image'];

        // Delete the book from the database
        $stmt = $conn->prepare("DELETE FROM `tbl_recipe` WHERE `tbl_recipe_id` = ?");
        $stmt->execute([$recipeID]);

        // Delete the associated image file
        if (!empty($recipeImage)) {
            $imagePath = "../uploads/" . $recipeImage;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Redirect to the page where you want to display the updated book list
        echo "<script>
        alert('Deleted Successfully'); 
        window.location.href = '../recipe-list.php';
        </script>";
        exit();
    } else {
        echo "Recipe not found"; // Handle the case where the recipe ID is not found
    }
}
?>
