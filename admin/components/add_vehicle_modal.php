<?php
function getBrands($connection)
{
    $sql = "SELECT id, name FROM brands";
    $result = $connection->query($sql);

    $brands = array();
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row; // Store the entire row for each brand
    }

    return $brands;
}
$allBrands = getBrands($connection);
?>
<div class="modal fade" id="addvehiclemodal" tabindex="-1" role="dialog" aria-labelledby="addvehiclemodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <!-- Include the form for adding a new Vehicle -->
            <form method="post" action="components/add_vehicle.php" enctype="multipart/form-data"
                onsubmit="return validateForm()">
                <div class="modal-header">
                    <h5 class="modal-title" id="addvehiclemodalLabel">Add Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <select class="form-control" id="brand" name="brand">
                                    <?php foreach ($allBrands as $brand): ?>
                                        <option value="<?= $brand['id'] ?>">
                                            <?= $brand['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small id="brandError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="title">Tittle</label>
                                <input type="text" class="form-control" id="title" name="title">
                                <small id="titleError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" id="year" name="year" min="1900" max="2099">
                                <small id="yearError" class="text-danger"></small>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" step="1.0" class="form-control" id="price" name="price">
                                <small id="priceError" class="text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="availability">Availability</label>
                                <select class="form-control" id="availability" name="availability">
                                    <option value="available">Available</option>
                                    <option value="unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control-file" id="image" name="image">
                                <small id="imageError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="vehicle_type">Vehicle Type</label>
                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                    <option value="car">Car</option>
                                    <option value="bike">Bike</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        // Retrieve the input values
        var brandInput = document.getElementById("brand").value;
        var titleInput = document.getElementById("title").value;
        var yearInput = document.getElementById("year").value;
        var priceInput = document.getElementById("price").value;
        var imageInput = document.getElementById("image").value;
        var vehicleTypeInput = document.getElementById("vehicle_type").value;

        // Perform validation for each field
        var isValid = true;

        if (brandInput.trim() === "") {
            showError("Please enter the Brand.");
            isValid = false;
        }

        if (titleInput.trim() === "") {
            showError("Please enter the Tittle.");
            isValid = false;
        }

        if (isNaN(yearInput) || yearInput.trim() === "") {
            showError("Please enter a valid Year.");
            isValid = false;
        }

        if (isNaN(priceInput) || priceInput.trim() === "") {
            showError("Please enter a valid Price.");
            isValid = false;
        }

        if (imageInput.trim() === "") {
            showError("Please select an Image.");
            isValid = false;
        } else {
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (!allowedExtensions.exec(imageInput)) {
                showError("Only images (JPG, JPEG, PNG, GIF) are allowed.");
                isValid = false;
            }
        }

        if (vehicleTypeInput.trim() === "") {
            showError("Please select a Vehicle Type.");
            isValid = false;
        }

        // Validation passed, allow form submission
        if (isValid) {
            submitForm();
        }

        return false; // Prevent the form from submitting normally
    }

    function showError(errorMessage) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: errorMessage,
        });
    }

    function submitForm() {
        // Submit the form using Fetch API
        var addVehicleForm = document.getElementById('addvehiclemodal').querySelector('form');
        fetch('components/add_vehicle.php', {
            method: 'POST',
            body: new FormData(addVehicleForm),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Vehicle Added!',
                        text: 'The vehicle has been successfully added.',
                    }).then(() => {
                        // Close the modal
                        $('#addvehiclemodal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to add the vehicle. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Display SweetAlert for unexpected error
                showError('An unexpected error occurred. Please try again.');
            });
    }
</script>