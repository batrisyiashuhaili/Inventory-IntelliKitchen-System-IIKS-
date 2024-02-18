<?php
$data = $_POST;

// Check if 'userId' key exists
if (isset($data['userId'])) {
    $user_id = (int) $data['userId'];
    $first_name = $data['f_name'];
    $last_name = $data['l_name'];
    $email = $data['email'];

    try {
        $sql = "UPDATE users SET email=?, first_name=?, last_name=?, updated_at=? WHERE user_id=?";
        include('connection.php');
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email, $first_name, $last_name, date('Y-m-d H:i:s'), $user_id]);

        echo json_encode([
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' successfully updated.'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your request!'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'User ID is required.Received data: ' . json_encode($data)
    ]);
}
