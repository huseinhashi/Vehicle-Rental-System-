<?php
include '../include/db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['address'];

    // Validate form data (example validation, adjust as needed)
    if (empty($fullName) || empty($email) || empty($contactNumber) || empty($address)) {
        // Handle validation error
        echo json_encode(array('status' => 'error', 'message' => 'Empty fields'));
        exit();
    }

    // Insert new customer into the database using prepared statements
    $insertQuery = "INSERT INTO customers (full_name, email, contact_number, address) VALUES (?, ?, ?, ?)";
    $statement = mysqli_prepare($connection, $insertQuery);
    mysqli_stmt_bind_param($statement, "ssss", $fullName, $email, $contactNumber, $address);
    mysqli_stmt_execute($statement);
    $insertedRows = mysqli_stmt_affected_rows($statement);
    mysqli_stmt_close($statement);

    if ($insertedRows > 0) {
        // Success
        echo json_encode(array('status' => 'success'));
        exit();
    } else {
        // Handle database error
        echo json_encode(array('status' => 'error', 'message' => 'Database error'));
        exit();
    }
} else {
    // Invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    exit();
}
?>