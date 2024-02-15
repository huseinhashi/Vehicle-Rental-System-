<?php
// Include your database connection file
include('../include/db.php');

// Check if vehicleId is set in the POST data
if (isset($_POST['vehicleId'])) {
    $vehicleId = $_POST['vehicleId'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM vehicles WHERE id = $vehicleId";
    $result = mysqli_query($connection, $deleteQuery);

    if ($result) {
        // Return a success response
        $response = array('status' => 'success');
    } else {
        // Return an error response
        $response = array('status' => 'success');
    }

    // Output the response as JSON
    echo json_encode($response);
} else {
    // If vehicleId is not set, return an error response
    $response = array('status' => 'error');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>