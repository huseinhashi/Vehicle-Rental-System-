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
                            ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['customer_full_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['vehicle_title']; ?>
                                </td>
                                <td>
                                    <?php echo $row['start_date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['return_date']; ?>
                                </td>
                                <td>
                                    <span id="status_<?php echo $row['id']; ?>" class="status-cell">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo '$ ' . $row['total_cost']; ?>
                                </td>
                                <td>

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