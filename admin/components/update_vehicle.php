<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicleId = $_POST['vehicle_id'];
    $updateBrand = $_POST['update_brand'];
    $updateModel = $_POST['update_model'];
    $updateYear = $_POST['update_year'];
    $updatePrice = $_POST['update_price'];
    $updateAvailability = $_POST['update_availability'];

    // Check if a new image file was uploaded
    if (isset($_FILES['update_image']) && $_FILES['update_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['update_image']['tmp_name'];
        $fileName = $_FILES['update_image']['name'];
        $fileSize = $_FILES['update_image']['size'];
        $fileType = $_FILES['update_image']['type'];

        // Validate and process the uploaded image file
        $uploadDirectory = '../../uploads/';
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            // Handle invalid file extension error
            header("Location: ../vehicles.php?error=invalidextension");
            exit();
        }

        // Generate a unique name for the uploaded image
        $newFileName = uniqid('', true) . '.' . $fileExtension;
        $destinationFilePath = $uploadDirectory . $newFileName;

        // Move the uploaded image to the desired directory
        if (!move_uploaded_file($fileTmpPath, $destinationFilePath)) {
            // Handle file upload error
            header("Location: ../vehicles.php?error=fileuploaderror");
            exit();
        }

        // Update the image file in the database
        $updateImageQuery = "UPDATE vehicles SET image = ? WHERE id = ?";
        $imageStatement = mysqli_prepare($connection, $updateImageQuery);
        mysqli_stmt_bind_param($imageStatement, "si", $newFileName, $vehicleId);
        mysqli_stmt_execute($imageStatement);
        mysqli_stmt_close($imageStatement);
    }

    // Update other vehicle information in the database
    $updateQuery = "UPDATE vehicles SET brand = ?, model = ?, year = ?, price = ?, availability = ? WHERE id = ?";
    $statement = mysqli_prepare($connection, $updateQuery);
    mysqli_stmt_bind_param($statement, "ssdssi", $updateBrand, $updateModel, $updateYear, $updatePrice, $updateAvailability, $vehicleId);
    mysqli_stmt_execute($statement);
    $updatedRows = mysqli_stmt_affected_rows($statement);
    mysqli_stmt_close($statement);

    if ($updatedRows > 0) {
        // Success
        header("Location: ../vehicles.php?success=vehicleupdated");
        exit();
    } else {
        // Handle database error
        header("Location: ../vehicles.php?error=databaseerror");
        exit();
    }
} else {
    // Redirect back to the form if accessed directly without submitting
    header("Location: ../vehicles.php");
    exit();
}
?>