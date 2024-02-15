<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vehicleId'])) {
    $vehicleId = $_POST['vehicleId'];

    // Fetch the current availability of the vehicle
    $getAvailabilitySql = "SELECT availability FROM vehicles WHERE id = $vehicleId";
    $getAvailabilityResult = mysqli_query($connection, $getAvailabilitySql);

    if ($getAvailabilityResult) {
        $currentAvailability = mysqli_fetch_assoc($getAvailabilityResult)['availability'];

        // Toggle the availability
        $newAvailability = ($currentAvailability == 'available') ? 'unavailable' : 'available';

        // Update the availability in the database
        $updateAvailabilitySql = "UPDATE vehicles SET availability = '$newAvailability' WHERE id = $vehicleId";
        $updateResult = mysqli_query($connection, $updateAvailabilitySql);

        if ($updateResult) {
            // Return updated availability and status class
            $response = array(
                'status' => 'success',
                'availabilityText' => ucfirst($newAvailability), // Capitalize first letter
                'newStatusClass' => ($newAvailability == 'available') ? 'badge-success' : 'badge-danger',
            );
            echo json_encode($response);
        } else {
            // Return an error response
            $response = array('status' => 'error', 'message' => 'Error updating availability');
            echo json_encode($response);
        }
    } else {
        // Return an error response
        $response = array('status' => 'error', 'message' => 'Error fetching current availability');
        echo json_encode($response);
    }
} else {
    // Return an error response for invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>