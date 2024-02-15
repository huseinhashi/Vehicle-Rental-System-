<?php
// Include your database connection file
include '../include/db.php';

// Assuming your form uses POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $hire_date = $_POST['hire_date'];
    $position_id = $_POST['position'];
    $salary = $_POST['salary'];

    // Retrieve the position name based on the position_id
    $position_query = "SELECT position_name FROM positions WHERE id = '$position_id'";
    $position_result = $connection->query($position_query);
    $position_row = $position_result->fetch_assoc();
    $position_name = $position_row['position_name'];

    // Insert the employee into the database
    $sql = "INSERT INTO employees (full_name, email, contact_number, address, hire_date, position, salary)
            VALUES ('$full_name', '$email', '$contact_number', '$address', '$hire_date', '$position_name', $salary)";

    if ($insertedRows > 0) {
        // Success
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // Handle database error, log the error, and send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error inserting customer: ' . mysqli_error($connection));
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