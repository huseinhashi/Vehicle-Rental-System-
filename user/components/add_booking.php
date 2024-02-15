<?php
// Include your database connection file
include '../include/db.php';

// Assuming your form uses POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_customer_id = $_POST['customer'];
    $selected_vehicle_id = $_POST['vehicle'];
    $start_date = $_POST['start_date'];
    $return_date = $_POST['return_date'];

    // Get the full name of the selected customer
    $customer_sql = "SELECT full_name FROM customers WHERE id = $selected_customer_id";
    $customer_result = $connection->query($customer_sql);
    $customer_row = $customer_result->fetch_assoc();
    $customer_full_name = $customer_row['full_name'];

    // Get the title and price of the selected vehicle
    $vehicle_sql = "SELECT title, price FROM vehicles WHERE id = $selected_vehicle_id";
    $vehicle_result = $connection->query($vehicle_sql);
    $vehicle_row = $vehicle_result->fetch_assoc();
    $vehicle_title = $vehicle_row['title'];
    $vehicle_price = $vehicle_row['price'];

    // Calculate the total cost based on the selected vehicle and date range
    $days_difference = ceil((strtotime($return_date) - strtotime($start_date)) / (60 * 60 * 24));
    $total_cost = $days_difference * $vehicle_price;

    // Validate form data (add your validation logic here)

    // Insert the booking into the database
    $sql = "INSERT INTO bookings (customer_id, vehicle_id, start_date, return_date, status, customer_full_name, vehicle_title, total_cost)
            VALUES ($selected_customer_id, $selected_vehicle_id, '$start_date', '$return_date', 'pending', '$customer_full_name', '$vehicle_title', $total_cost)";
    if ($connection->query($sql) === TRUE) {
        // If the booking is inserted successfully, you can send a success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error inserting booking: ' . $connection->error);
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