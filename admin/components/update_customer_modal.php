<!-- Update Customer Modal -->
<div class="modal fade" id="updateCustomerModal" tabindex="-1" role="dialog" aria-labelledby="updateCustomerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCustomerModalLabel">Update Customer Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="components/update_customer.php" method="POST" id="updateCustomerForm">
                <div class="modal-body">

                    <input type="hidden" name="updateCustomerId" id="updateCustomerId">

                    <div class="form-group">
                        <label for="update_full_name_customer">Full Name</label>
                        <input type="text" name="update_full_name_customer" id="update_full_name_customer"
                            class="form-control" placeholder="Enter Full Name">
                    </div>

                    <div class="form-group">
                        <label for="update_email_customer">Email</label>
                        <input type="email" name="update_email_customer" id="update_email_customer" class="form-control"
                            placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="update_contact_number_customer">Contact Number</label>
                        <input type="text" name="update_contact_number_customer" id="update_contact_number_customer"
                            class="form-control" placeholder="Enter Contact Number">
                    </div>

                    <div class="form-group">
                        <label for="update_address_customer">Address</label>
                        <textarea name="update_address_customer" id="update_address_customer" class="form-control"
                            placeholder="Enter Address" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUpdateCustomerForm()">Update
                        Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission for updating a customer
    function submitUpdateCustomerForm() {
        fetch('components/update_customer.php', {
            method: 'POST',
            body: new FormData(document.getElementById('updateCustomerForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer Updated!',
                        text: 'The customer has been successfully updated.',
                    }).then(() => {
                        // Close the modal
                        $('#updateCustomerModal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to update the customer. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Display SweetAlert for unexpected error
                showError('An unexpected error occurred. Please try again.');
            });
    }
</script>