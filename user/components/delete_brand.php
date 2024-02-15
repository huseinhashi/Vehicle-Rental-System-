<?php
// Include your database connection file
include('../include/db.php');

// Check if brandId is set in the POST data
if (isset($_POST['brandId'])) {
    $brandId = $_POST['brandId']; // Fix the variable name here

    // Perform the deletion query
    $deleteQuery = "DELETE FROM brands WHERE id = $brandId";
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
    // If brandId is not set, return an error response
    $response = array('status' => 'error');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>