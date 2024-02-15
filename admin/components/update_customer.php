<?php
// Include your database connection file
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customerId = $_POST['updateCustomerId'];
    $full_name = $_POST['update_full_name_customer'];
    $email = $_POST['update_email_customer'];
    $contact_number = $_POST['update_contact_number_customer'];
    $address = $_POST['update_address_customer'];
    // Update the customer in the database using prepared statements
    $sql = "UPDATE customers
        SET full_name = ?, email = ?, contact_number = ?, address = ?
        WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssi", $full_name, $email, $contact_number, $address, $customerId);

    if ($stmt->execute()) {
        // If the customer is updated successfully, you can send a success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error updating customer: ' . $stmt->error);
        echo json_encode($response);
    }

    // Close the statement
    $stmt->close();
} else {
    // If the request method is not POST, you can send an error response
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}

// Close the database connection
$connection->close();
?>