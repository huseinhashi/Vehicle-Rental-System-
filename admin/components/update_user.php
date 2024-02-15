<?php
// Include your database connection file
include '../include/db.php';

// Assuming your form uses POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['updateUserId'];
    $username = $_POST['update_username'];
    $email = $_POST['update_email'];
    $role = $_POST['update_role'];

    // Validate form data (add your validation logic here)

    // Update the user in the database using prepared statements
    $sql = "UPDATE users
            SET username = ?, email = ?, role = ?
            WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $role, $userId);

    if ($stmt->execute()) {
        // If the user is updated successfully, you can send a success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error updating user: ' . $stmt->error);
        echo json_encode($response);
    }

    // Close the statement
    $stmt->close();
} else {
    // If the request method is not POST, you can send an error response
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}

// Close the database connection
$connection->close();
?>