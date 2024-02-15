<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeId = $_POST['updateEmployeeId'];
    $fullName = $_POST['update_full_name'];
    $email = $_POST['update_email'];
    $contactNumber = $_POST['update_contact_number'];
    $address = $_POST['update_address'];
    $hireDate = $_POST['update_hire_date'];
    $position = $_POST['update_position'];
    $salary = $_POST['update_salary'];
    // Retrieve the position name based on the position_id
    $position_query = "SELECT position_name FROM positions WHERE id = '$position'";
    $position_result = $connection->query($position_query);
    $position_row = $position_result->fetch_assoc();
    $position_name = $position_row['position_name'];
    // Validate form data (add your validation logic here)

    // Update the employee in the database using prepared statements
    $sql = "UPDATE employees
        SET full_name = ?, email = ?, contact_number = ?,
            address = ?, hire_date = ?, position = ?, salary = ?
        WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssdi", $fullName, $email, $contactNumber, $address, $hireDate, $position_name, $salary, $employeeId);

    if ($stmt->execute()) {
        // If the employee is updated successfully, you can send a success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If there is an error, you can send an error response with a detailed message
        $response = array('status' => 'error', 'message' => 'Error updating employee: ' . $stmt->error);
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