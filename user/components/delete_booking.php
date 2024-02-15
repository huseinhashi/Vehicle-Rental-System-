<?php
// Include your database connection file
include('../include/db.php');

// Check if bookingId is set in the POST data
if (isset($_POST['bookingId'])) {
    $bookingId = $_POST['bookingId'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM bookings WHERE id = $bookingId";
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
    // If bookingId is not set, return an error response
    $response = array('status' => 'error');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>