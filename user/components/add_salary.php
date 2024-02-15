<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $selected_employee_id = $_POST['employee'];
    $payment_date = $_POST['payment_date'];
    $amount = $_POST['amount'];

    // Get the full name of the selected employee
    $employee_sql = "SELECT full_name FROM employees WHERE id = $selected_employee_id";
    $employee_result = $connection->query($employee_sql);

    if ($employee_result) {
        $employee_row = $employee_result->fetch_assoc();
        $employee_full_name = $employee_row['full_name'];

        // Validate form data (add your validation logic here)

        // Insert the salary into the database
        $sql = "INSERT INTO salaries (employee_id, payment_date, amount, employee_full_name)
                VALUES ($selected_employee_id, '$payment_date', $amount, '$employee_full_name')";

        if ($connection->query($sql) === TRUE) {
            // If the salary is inserted successfully, you can send a success response
            $response = array('status' => 'success');
            echo json_encode($response);
        } else {
            // If there is an error, you can send an error response with a detailed message
            $response = array('status' => 'error', 'message' => 'Error inserting salary: ' . $connection->error);
            echo json_encode($response);
        }
    } else {
        // If there is an error retrieving the employee data, send an error response
        $response = array('status' => 'error', 'message' => 'Error retrieving employee data: ' . $connection->error);
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