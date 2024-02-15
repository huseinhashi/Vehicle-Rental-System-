<?php
include 'include/header.php';
include 'include/db.php';


// Fetch all maintenance records from the database
$query = "SELECT * FROM maintenance";
$result = mysqli_query($connection, $query);

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Maintenance</h4>
                    <p class="card-description">
                        <?php
                        $numMaintenance = mysqli_num_rows($result);
                        echo "Maintenance records in the system: " . $numMaintenance . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addmaintenancemodal">
                        Add New Maintenance
                    </button>


                </div>
            </div>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Maintenance Date</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Vehicle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowColorClasses = ['table-info'];

                        while ($row = mysqli_fetch_assoc($result)) {
                            $colorClass = $rowColorClasses[$counter % count($rowColorClasses)];
                            $counter++;
                            ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['vehicle_id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['maintenance_date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['description']; ?>
                                </td>
                                <td>
                                    <?php echo '$ ' . $row['cost']; ?>
                                </td>
                                <td>
                                    <?php echo $row['vehicle_title']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success updateBtn" data-toggle="modal">
                                        Update
                                    </button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteMaintenanceModal(<?php echo $row['id']; ?>)">
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

<!-- Include Add Booking Modal -->
<?php include 'components/add_maintenance_modal.php'; ?>
<?php include 'include/footer.php'; ?>

<script>

    $(document).ready(function () {
        $('.updateBtn').on('click', function () {
            $('#updateModal').modal('show');
            $tr = $(this).closest('tr');
            var id = $tr.find("td:eq(0)").text();
            var vehicleId = $tr.find("td:eq(1)").text();
            var maintenanceDate = $tr.find("td:eq(2)").text();
            var description = $tr.find("td:eq(3)").text();
            var cost = $tr.find("td:eq(4)").text().replace('$ ', ''); // Remove currency symbol
            var employeeName = $tr.find("td:eq(5)").text();
            $('#update_id').val(id);
            $('#vehicle_id').val(vehicleId);
            $('#maintenance_date').val(maintenanceDate);
            $('#description').val(description);
            $('#cost').val(cost);
            $('#employee_name').val(employeeName);
        });
    });

    // Function to handle SweetAlert confirmation and initiate deletion
    function deleteMaintenanceModal(maintenanceId) {
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
                deleteMaintenance(maintenanceId);
            }
        });
    }

    // Function to perform AJAX deletion for maintenance
    function deleteMaintenance(maintenanceId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_maintenance.php',
            data: { maintenanceId: maintenanceId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#maintenance_' + maintenanceId).remove();

                    // Display a success SweetAlert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Maintenance record deleted successfully.',
                        icon: 'success',
                    }).then((result) => {
                        // Reload the page when the user clicks "OK"
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload();
                        }
                    });
                }
            }
        });
    }

</script>
<?php include 'components/update_booking_modal.php'; ?>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>