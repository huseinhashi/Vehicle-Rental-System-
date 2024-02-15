<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookingId']) && isset($_POST['newStatus'])) {
    // Retrieve booking ID and new status
    $bookingId = $_POST['bookingId'];
    $newStatus = $_POST['newStatus'];

    // Update the booking status in the database
    $sql = "UPDATE bookings SET status = '$newStatus' WHERE id = $bookingId";

    if ($connection->query($sql) === TRUE) {
        // If the status is updated successfully, you can send a success response
        $response = array('status' => 'success', 'statusText' => $newStatus);
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error updating status: ' . $connection->error);
        echo json_encode($response);
    }
} else {
    // If the request method is not POST or bookingId or newStatus is not set, send an error response
    $response = array('status' => 'error', 'message' => 'Invalid request');
    echo json_encode($response);
}

// Close the database connection
$connection->close();
?>