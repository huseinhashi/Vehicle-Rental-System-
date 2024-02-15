<?php
include 'include/header.php';
include 'include/db.php';


// Fetch all bookings from the database
$query = "SELECT * FROM bookings";
$result = mysqli_query($connection, $query);

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Bookings</h4>
                    <p class="card-description">
                        <?php
                        $numBookings = mysqli_num_rows($result);
                        echo "Bookings in the system: " . $numBookings . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addbookingmodal">
                        Add New Booking
                    </button>
                </div>
            </div>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Start Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Total Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowColorClasses = ['table-info'];

                        while ($row = mysqli_fetch_assoc($result)) {
                            $colorClass = $rowColorClasses[$counter % count($rowColorClasses)];
                            $counter++;

                            // Fetch customer details
                            $customerQuery = "SELECT full_name FROM customers WHERE id = " . $row['customer_id'];
                            $customerResult = mysqli_query($connection, $customerQuery);
                            $customer = mysqli_fetch_assoc($customerResult);

                            // Fetch vehicle details
                            $vehicleQuery = "SELECT title FROM vehicles WHERE id = " . $row['vehicle_id'];
                            $vehicleResult = mysqli_query($connection, $vehicleQuery);
                            $vehicle = mysqli_fetch_assoc($vehicleResult);
                            ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $customer['full_name']; ?>
                                </td>
                                <td>
                                    <?php echo $vehicle['title']; ?>
                                </td>
                                <td>
                                    <?php echo $row['start_date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['return_date']; ?>
                                </td>
                                <td>
                                    <span id="status_<?php echo $row['id']; ?>" class="status-cell"
                                        onclick="toggleStatus(<?php echo $row['id']; ?>)" style="display: inline-block; padding: 5px 10px; border-radius: 5px;
                                               color: #ffffff;
                                               <?php
                                               if ($row['status'] === 'pending') {
                                                   echo 'background-color: #ffcc00;';
                                               } elseif ($row['status'] === 'confirmed') {
                                                   echo 'background-color: #00cc00;';
                                               } elseif ($row['status'] === 'cancelled') {
                                                   echo 'background-color: #ff0000;';
                                               }
                                               ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo $row['total_cost']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success update-btn" data-toggle="modal">
                                        Update
                                    </button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteBookingModal(<?php echo $row['id']; ?>)">
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
<?php include 'components/add_booking_modal.php'; ?>

<?php include 'include/footer.php'; ?>
<script>
    // Function to toggle booking status
    function toggleStatus(bookingId) {
        // Show confirmation alert with Confirm and Cancel buttons
        Swal.fire({
            title: 'Update Status',
            text: 'Do you want to update the status of this booking?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with updating status to "Confirmed"
                updateBookingStatus(bookingId, 'Confirmed');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // User clicked Cancel, proceed with updating status to "Cancelled"
                updateBookingStatus(bookingId, 'Cancelled');
            }
        });
    }

    // AJAX request to update booking status
    // AJAX request to update booking status
    function updateBookingStatus(bookingId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'components/update_booking_status.php',
            data: { bookingId: bookingId, newStatus: newStatus },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Display success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated!',
                        text: 'The status has been updated to ' + response.statusText + '.',
                    }).then(() => {
                        // Update the status cell content
                        $('#status_' + bookingId).text(response.statusText);
                    }).then(() => {
                        // Reload the page after the status is updated
                        location.reload();
                    });
                } else {
                    // Display error SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status. Please try again.',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                });
            }
        });
    }

</script>

<script>

    $(document).ready(function () {
        $('.udatebtn').on('click', function () {
            $('#updatemodal').modal('show');
            $tr = $(this).closest('tr');
            var id = $tr.find("td:eq(0)").text();
            var customer = $tr.find("td:eq(1)").text();
            var vehicle = $tr.find("td:eq(2)").text();
            var startDate = $tr.find("td:eq(3)").text();
            var returnDate = $tr.find("td:eq(4)").text();
            $('#update_id').val(id);
            $('#customer_full_name').val(customer);
            $('#vehicle_title').val(vehicle);
            $('#start_date').val(startDate);
            $('#return_date').val(returnDate);
        });
    });
    // Function to handle SweetAlert confirmation and initiate deletion
    function deleteBookingModal(bookingId) {
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
                deleteBooking(bookingId);
            }
        });
    }
    // Function to perform AJAX deletion
    function deleteBooking(bookingId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_booking.php',
            data: { bookingId: bookingId },
            dataType: 'json',  // Expect JSON response
            success: function (response) {
                if (response.status === 'success') {
                    $('#booking_' + bookingId).remove();

                    // Display a success SweetAlert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Booking deleted successfully.',
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