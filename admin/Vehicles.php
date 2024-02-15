<?php
include 'include/header.php';
include 'include/db.php';

// Fetch all vehicles from the database
$query = "SELECT * FROM vehicles";
$result = mysqli_query($connection, $query);

// Include the Add Vehicle Modal
include 'components/add_vehicle_modal.php';
include 'components/update_vehicle_modal.php';

$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Vehicles</h4>
                    <p class="card-description">
                        <?php
                        $numVehicles = mysqli_num_rows($result);
                        echo "Vehicles in the system: " . $numVehicles . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addvehiclemodal">Add
                        New Vehicle</button>
                </div>
            </div>
            <div class="table-responsive pt-2">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Tittle</th>
                            <th>Price per day</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowColorClasses = ['table-info', 'table-warning', 'table-danger', 'table-success', 'table-primary'];

                        while ($row = mysqli_fetch_assoc($result)) {
                            $colorClass = $rowColorClasses[$counter % count($rowColorClasses)];
                            $counter++;
                            ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <img src="../uploads/<?php echo $row['image']; ?>" alt="Vehicle Image"
                                        class="vehicle-image" style="max-width: 500px; max-height: 50px;">
                                </td>
                                <td>
                                    <?php echo $row['vehicle_type']; ?>
                                </td>
                                <td>
                                    <?php echo $row['brand']; ?>
                                </td>
                                <td>
                                    <?php echo $row['title']; ?>
                                </td>

                                <td>
                                    <?php echo '$' . $row['price']; ?>
                                </td>
                                <td>
                                    <?php
                                    $availability = $row['availability'];
                                    $statusClass = ($availability == 'available') ? 'badge-success' : 'badge-danger';
                                    $statusText = ($availability == 'available') ? 'Available' : 'Unavailable';
                                    ?>
                                    <span id="availability_<?php echo $row['id']; ?>"
                                        class="badge <?php echo $statusClass; ?>"
                                        onclick="toggleAvailability(<?php echo $row['id']; ?>)">
                                        <?php echo $statusText; ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success">
                                        Update
                                    </button>



                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteVehicle(<?php echo $row['id']; ?>)">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // Function to toggle availability
    function toggleAvailability(vehicleId) {
        // Show confirmation alert
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update the availability?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with updating availability
                updateAvailability(vehicleId);
            }
        });
    }

    // AJAX request to update availability
    function updateAvailability(vehicleId) {
        $.ajax({
            type: 'POST',
            url: 'components/toggle_availability.php',
            data: { vehicleId: vehicleId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Availability Updated!',
                        text: 'The availability has been updated to ' + response.availabilityText + '.',
                    }).then(() => {
                        // Update the availability cell content and class
                        $('#availability_' + vehicleId).text(response.availabilityText);
                        $('#availability_' + vehicleId).removeClass('badge-success badge-danger');
                        $('#availability_' + vehicleId).addClass(response.newStatusClass);
                    });
                } else {
                    // Display SweetAlert for error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update availability. Please try again.',
                    });
                }
            },
            error: function () {
                // Display SweetAlert for unexpected error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                });
            }
        });
    }

    // Attach click event listener to availability cells
    $(document).ready(function () {
        $('td.availability-cell').on('click', function () {
            // Get the vehicle ID from the data-vehicle-id attribute
            var vehicleId = $(this).data('vehicle-id');
            toggleAvailability(vehicleId);
        });
    });
</script>

<script>
    function deleteVehicle(vehicleId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with deletion
                deleteVehicleAjax(vehicleId);
            }
        });
    }

    // AJAX request to delete vehicle
    function deleteVehicleAjax(vehicleId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_vehicle.php',
            data: { vehicleId: vehicleId },
            success: function (response) {
                if (response.status === 'success') {
                    // Assuming the row ID is used to identify the vehicle in the HTML
                    $('#vehicle_' + vehicleId).remove();

                    // Display a success SweetAlert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Vehicle deleted successfully.',
                        icon: 'success',
                    }).then((result) => {
                        // Reload the page when the user clicks "OK"
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload();
                        }
                    });

                }
                else {
                    // Display a success SweetAlert
                    Swal.fire('Deleted!', 'Customer deleted successfully.', 'success').then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload();
                        }
                    });
                }
            },
        });
    }
</script>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<?php
include 'include/footer.php';
?>