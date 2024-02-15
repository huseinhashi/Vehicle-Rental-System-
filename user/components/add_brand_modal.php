<!-- add_brand_modal.php -->
<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog" aria-labelledby="addBrandModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrandModalLabel">Add New Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addBrandForm">
                <div class="modal-body">
                    <!-- Add form fields for brand name and other details as needed -->
                    <div class="form-group">
                        <label for="brandName">Brand Name</label>
                        <input type="text" class="form-control" id="brandName" name="brandName" required>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addBrandForm = document.getElementById('addBrandForm');
        const addBrandModal = $('#addBrandModal');

        // Function to handle form submission
        function handleFormSubmission(e) {
            e.preventDefault();

            // Submit the form using Fetch API
            fetch('components/add_brand.php', {
                method: 'POST',
                body: new FormData(addBrandForm),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'error') {
                        // Display SweetAlert for error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                        })
                    } else if (data.status === 'success') {
                        // Display SweetAlert for success
                        Swal.fire({
                            icon: 'success',
                            title: 'Brand Added!',
                            text: data.message,
                        });
                    } else {
                        // Display SweetAlert for other error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add the brand. Please try again.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Display SweetAlert for unexpected error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.',
                    });
                });
        }

        // Add event listener to the form submission
        addBrandForm.addEventListener('submit', handleFormSubmission);
    });
</script>