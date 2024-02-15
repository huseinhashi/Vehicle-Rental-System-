<?php
// Include your database connection file
include('../include/db.php');

// Check if customerId is set in the POST data
if (isset($_POST['customerId'])) {
    $customerId = $_POST['customerId'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM customers WHERE id = $customerId";
    $result = mysqli_query($connection, $deleteQuery);

    if ($result) {
        // Return a success response
        $response = array('status' => 'success');
    } else {
        // Return an error response
        $response = array('status' => 'error');
    }

    // Output the response as JSON
    echo json_encode($response);
} else {
    // If customerId is not set, return an error response
    $response = array('status' => 'error');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>