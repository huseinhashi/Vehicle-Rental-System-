<!-- EDIT POP UP FORM (Bootstrap MODAL) -->
<div class="modal fade" id="updatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Booking Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="updateBookingForm" action="components/update_booking.php" method="POST"
                onsubmit="return validateUpdateForm();">

                <div class="modal-body">

                    <input type="hidden" name="update_id" id="update_id">

                    <div class="form-group">
                        <label>Customer</label>
                        <input type="text" name="customer_full_name" id="customer_full_name" class="form-control"
                            placeholder="Enter Customer Name">
                    </div>

                    <div class="form-group">
                        <label>Vehicle</label>
                        <input type="text" name="vehicle_title" id="vehicle_title" class="form-control"
                            placeholder="Enter Vehicle Title">
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Return Date</label>
                        <input type="date" name="return_date" id="return_date" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Function to validate the update form
    function validateUpdateForm() {
        // Add validation logic if needed
        return true;
    }

    document.getElementById('updateBookingForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Perform AJAX update
        fetch('components/update_booking.php', {
            method: 'POST',
            body: new FormData(this),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    $('#updateBookingModal').modal('hide');

                    // Display a success SweetAlert
                    Swal.fire('Updated!', 'Booking updated successfully.', 'success');
                    location.reload();
                } else {
                    // Display an error SweetAlert
                    Swal.fire('Error!', 'Failed to update booking. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Display an error SweetAlert
                Swal.fire('Error!', 'An unexpected error occurred. Please try again.', 'error');
            });
    });
</script>