<?php
$data = $_POST;
$user_id = (int) $data['user_id'];
$first_name = $data['f_name'];
$last_name = $data['l_name'];

// Adding the record.
try {
    // Include the connection file
    include('connection.php');

    // Prepare and execute the DELETE query
    $command = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($command);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => $first_name . ' ' . $last_name . ' successfully deleted.'
    ]);
} catch (mysqli_sql_exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error processing your request!'
    ]);
}

$conn->close();