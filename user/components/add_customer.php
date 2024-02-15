<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];
    $address = $_POST['address'];

    // Validate form data (example validation, adjust as needed)
    if (empty($fullName) || empty($email) || empty($contactNumber) || empty($address)) {
        // Handle validation error, e.g., redirect back to the form with an error message
        header("Location: ../customers.php?error=emptyfields");
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
        header("Location: ../customers.php?success=customeradded");
        exit();
    } else {
        // Handle database error, e.g., redirect back to the form with an error message
        header("Location: ../customers.php?error=databaseerror");
        exit();
    }
} else {
    // Redirect back to the form if accessed directly without submitting
    header("Location: ../customers.php");
    exit();
}
?>