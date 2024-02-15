<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize input data
    $customerId = filter_input(INPUT_POST, 'customer', FILTER_VALIDATE_INT);
    $vehicleId = filter_input(INPUT_POST, 'vehicle', FILTER_VALIDATE_INT);
    $startDate = filter_input(INPUT_POST, 'start_date');
    $returnDate = filter_input(INPUT_POST, 'return_date');

    // Validate the data
    if (!$customerId || !$vehicleId || !$startDate || !$returnDate) {
        $response = array('status' => 'error', 'message' => 'Invalid input data');
        echo json_encode($response);
        exit;
    }


    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO bookings (customer_id, vehicle_id, start_date, return_date, status, total_cost) 
              VALUES (?, ?, ?, ?, 'pending', ?)";

    $stmt = $connection->prepare($query);

    if (!$stmt) {
        $response = array('status' => 'error', 'message' => 'Failed to prepare statement');
        echo json_encode($response);
        exit;
    }

    // Fetch vehicle price
    $getVehiclePriceQuery = "SELECT price FROM vehicles WHERE id = ?";
    $getVehiclePriceStmt = $connection->prepare($getVehiclePriceQuery);
    $getVehiclePriceStmt->bind_param('i', $vehicleId);
    $getVehiclePriceStmt->execute();
    $getVehiclePriceStmt->bind_result($vehiclePrice);

    if ($getVehiclePriceStmt->fetch()) {
        $getVehiclePriceStmt->close();

        // Calculate total_cost based on date range and vehicle price
        $startDateTimestamp = strtotime($startDate);
        $returnDateTimestamp = strtotime($returnDate);
        $daysDifference = ceil(($returnDateTimestamp - $startDateTimestamp) / (60 * 60 * 24));
        $totalCost = $daysDifference * $vehiclePrice;

        // Bind parameters
        $stmt->bind_param('iissd', $customerId, $vehicleId, $startDate, $returnDate, $totalCost);

        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();

            $response = array('status' => 'success');
            echo json_encode($response);
            exit;
        } else {
            $stmt->close();

            $response = array('status' => 'error', 'message' => 'Failed to execute statement');
            echo json_encode($response);
            exit;
        }
    } else {
        $getVehiclePriceStmt->close();

        $response = array('status' => 'error', 'message' => 'Failed to fetch vehicle price');
        echo json_encode($response);
        exit;
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
    exit;
}
?>