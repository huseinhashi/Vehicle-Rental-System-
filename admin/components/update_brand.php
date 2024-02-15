<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $brandId = $_POST['updateBrandId'];
    $Name = $_POST['update_name'];
    // Update the employee in the database using prepared statements
    $sql = "UPDATE brands
        SET name = ?, 
        WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssdi", $Name, $brandId);

    if ($stmt->execute()) {
        // If the Brand is updated successfully, you can send a success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error updating Brand: ' . $stmt->error);
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