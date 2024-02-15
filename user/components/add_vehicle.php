<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data
        $brand = $_POST['brand'];
        $title = $_POST['title'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $vehicleType = $_POST['vehicle_type'];

        // Validate form data (example validation, adjust as needed)
        if (empty($brand) || empty($title) || empty($year) || empty($price) || empty($availability) || empty($vehicleType)) {
            throw new Exception("One or more form fields are empty");
        }

        // Check if an image file was uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];

            // Validate and process the uploaded image file
            $uploadDirectory = '../../uploads/'; // 
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Invalid file extension");
            }

            // Generate a unique name for the uploaded image
            $newFileName = uniqid('', true) . '.' . $fileExtension;
            $destinationFilePath = $uploadDirectory . $newFileName;

            // Move the uploaded image to the desired directory
            if (!move_uploaded_file($fileTmpPath, $destinationFilePath)) {
                throw new Exception("Failed to move the uploaded image");
            }

            // Insert new vehicle into the database using prepared statements
            $insertQuery = "INSERT INTO vehicles (brand, title, year, price, availability, image, vehicle_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = mysqli_prepare($connection, $insertQuery);
            mysqli_stmt_bind_param($statement, "sssssss", $brand, $title, $year, $price, $availability, $newFileName, $vehicleType);
            mysqli_stmt_execute($statement);
            $insertedRows = mysqli_stmt_affected_rows($statement);
            mysqli_stmt_close($statement);

            if ($insertedRows > 0) {
                // Success
                echo json_encode(['status' => 'success']);
                exit();
            } else {
                // Handle database error
                throw new Exception("Failed to insert the vehicle into the database");
            }
        } else {
            // Handle image upload error or no image selected error
            throw new Exception("Image upload error or no image selected");
        }
    } catch (Exception $e) {
        // Log the error
        error_log($e->getMessage());

        // Return an error response
        echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. Please try again.']);
        exit();
    }
} else {
    // Return an error response for invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}
?>