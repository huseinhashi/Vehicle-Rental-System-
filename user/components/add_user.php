<?php
// Include your database connection file
include('../include/db.php');

// Check if the required fields are set in the POST data
if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['role']) &&
    isset($_POST['full_name']) &&
    isset($_POST['contact_number']) &&
    isset($_POST['address'])
) {
    // Sanitize and store the values from the POST data
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $contact_number = mysqli_real_escape_string($connection, $_POST['contact_number']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);

    // Perform the insertion query
    $insertQuery = "INSERT INTO users (username, email, password, role, full_name, contact_number, address) 
                    VALUES ('$username', '$email', '$password', '$role', '$full_name', '$contact_number', '$address')";
    $result = mysqli_query($connection, $insertQuery);

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
    // If required fields are not set, return an error response
    $response = array('status' => 'error');
    echo json_encode($response);
}

// Close the database connection
mysqli_close($connection);
?>