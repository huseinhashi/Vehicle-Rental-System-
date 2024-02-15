<?php
// Include your database connection file
include '../include/db.php';

// Assuming your form uses POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_vehicle_id = $_POST['vehicle'];
    $maintenance_date = $_POST['maintenance_date'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];

    // Get the title of the selected vehicle
    $vehicle_sql = "SELECT title FROM vehicles WHERE id = $selected_vehicle_id";
    $vehicle_result = $connection->query($vehicle_sql);
    $vehicle_row = $vehicle_result->fetch_assoc();
    $vehicle_title = $vehicle_row['title'];

    // Validate form data (add your validation logic here)

    // Insert the maintenance record into the database
    $sql = "INSERT INTO maintenance (vehicle_id, maintenance_date, description, cost, vehicle_title)
            VALUES ($selected_vehicle_id, '$maintenance_date', '$description', $cost, '$vehicle_title')";
    if ($connection->query($sql) === TRUE) {
        // If the maintenance record is inserted successfully, you can send a success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error inserting maintenance record: ' . $connection->error);
        echo json_encode($response);
    }
} else {
    // If the request method is not POST, you can send an error response
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}

// Close the database connection
$connection->close();
?>