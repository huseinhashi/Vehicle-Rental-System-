<?php
// Include your database connection file
include('../include/db.php');

// Check if userId is set in the POST data
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM users WHERE id = $userId";
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
    // If userId is not set, return an error response
    $response = array('status' => 'error');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>