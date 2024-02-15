<!-- add_maintenance_modal.php -->
<?php
// Include your database connection file
include '../include/db.php';

function getAvailableVehicles($connection)
{
    $sql = "SELECT id, title FROM vehicles WHERE availability = 'available'";
    $result = $connection->query($sql);

    $vehicles = array();
    while ($row = $result->fetch_assoc()) {
        $vehicles[$row['id']] = $row['title'];
    }

    return $vehicles;
}

// $connection is now available for use

$availableVehicles = getAvailableVehicles($connection);
?>

<!-- Modal HTML/PHP code -->
<div class="modal fade" id="addmaintenancemodal" tabindex="-1" role="dialog" aria-labelledby="addmaintenancemodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <form method="post" action="components/add_maintenance.php" onsubmit="return validateForm()"
                id="maintenanceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addmaintenancemodalLabel">Add Maintenance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vehicle">Vehicle</label>
                        <select class="form-control" id="vehicle" name="vehicle" required>
                            <option value="" disabled selected>Choose vehicle</option>
                            <?php
                            foreach ($availableVehicles as $id => $vehicleTitle) {
                                echo "<option value=\"$id\">$vehicleTitle</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="maintenance_date">Maintenance Date</label>
                        <input type="date" class="form-control" id="maintenance_date" name="maintenance_date" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input type="text" class="form-control" id="cost" name="cost" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitMaintenanceForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Bootstrap JavaScript libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.getElementById('maintenanceForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Continue with form submission if all validations pass
        fetch('components/add_maintenance.php', {
            method: 'POST',
            body: new FormData(document.getElementById('maintenanceForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('maintenanceForm').reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Maintenance Record Added!',
                        text: 'The maintenance record has been successfully added.',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Close the modal
                            $('#addmaintenancemodal').modal('hide');

                            // Reload the page or perform any other action
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to add the maintenance record. Please try again.',
                        confirmButtonText: 'OK',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    confirmButtonText: 'OK',
                });
            });
    });
</script>