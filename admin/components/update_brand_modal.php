<!-- Update brand Modal -->
<div class="modal fade" id="updateBrandModal" tabindex="-1" role="dialog" aria-labelledby="updateBrandModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBrandModalLabel">Update Brand Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="components/update_brand.php" method="POST" id="UpdateBrandForm">
                <div class="modal-body">

                    <input type="hidden" name="updateBrandId" id="updateBrandId">

                    <div class="form-group">
                        <label for="update_name">Full Name</label>
                        <input type="text" name="update_name" id="update_name" class="form-control"
                            placeholder="Enter Full Name">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitUpdateBrandForm()">Update
                            Data</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission for updating an brand
    function submitUpdateBrandForm() {
        fetch('components/update_brand.php', {
            method: 'POST',
            body: new FormData(document.getElementById('UpdateBrandForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'brand Updated!',
                        text: 'The brand has been successfully updated.',
                    }).then(() => {
                        // Close the modal
                        $('#updateBrandModal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to update the Brand. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Display SweetAlert for unexpected error
                showError('An unexpected error occurred. Please try again.');
            });
    }

    // Function to show SweetAlert for error messages
    function showError(message) {
        Swal.fire({
            icon: 'success',
            title: 'success',
            text: "succesfulyy Updated  ",
        }).then(() => {
            location.reload();
        });
    }
</script>