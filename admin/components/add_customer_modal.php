<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Include the form for adding a new customer -->
            <form method="post" action="components/add_customer.php" id="customerForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitCustomerForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission for adding a customer
    function submitCustomerForm() {
        fetch('components/add_customer.php', {
            method: 'POST',
            body: new FormData(document.getElementById('customerForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Added!',
                        text: 'The customer has been successfully added.',
                    }).then(() => {
                        // Close the modal
                        $('#addCustomerModal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to add the customer. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Display SweetAlert for unexpected error
                showError('An unexpected error occurred. Please try again.');
            });
    }
</script>