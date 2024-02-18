<?php
// Include the connection file
include('connection.php');

$data = $_POST;

// Check if 'id' and 'table' keys exist in the $_POST array
if (isset($data['id'], $data['table'])) {
    $id = (int)$data['id'];
    $table = $data['table'];

    // Prepare and execute the DELETE query
    $command = $conn->prepare("DELETE FROM $table WHERE id=?");
    $command->bind_param('i', $id);

    // Adding the record.
    try {
        $command->execute();

        echo json_encode([
            'success' => true,
        ]);
    } catch (mysqli_sql_exception $e) {
        echo json_encode([
            'success' => false,
        ]);
    }

    $command->close();
} else {
    // Handle the case where 'id' or 'table' is not present in $_POST
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters (id or table).',
    ]);
}

$conn->close();
?>
