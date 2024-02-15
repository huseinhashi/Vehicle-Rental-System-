<?php
include '../include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandName = $_POST['brandName'];

    // Validate and sanitize input as needed

    // Check if the brand already exists
    $query = "SELECT * FROM brands WHERE name = '$brandName'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // If the brand already exists, send an error response
        $response = array('status' => 'error', 'message' => 'Brand already exists');
        echo json_encode($response);
    } else {
        // Insert the new brand
        $insertQuery = "INSERT INTO brands (name) VALUES ('$brandName')";
        $insertResult = mysqli_query($connection, $insertQuery);

        if ($insertResult) {
            // If the brand is inserted successfully, send a success response
            $response = array('status' => 'success', 'message' => 'Successfully added');
            echo json_encode($response);
        } else {
            // If there is an error, send an error response with a detailed message
            $response = array('status' => 'error', 'message' => 'Error inserting brand: ' . mysqli_error($connection));
            echo json_encode($response);
        }
    }
} else {
    // If the request method is not POST, send an error response
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>