<!-- change_profile_modal.php -->
<div class="modal fade" id="changeProfileModal" tabindex="-1" role="dialog" aria-labelledby="changeProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeProfileModalLabel">Change Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for updating user profile -->
                <form id="profileUpdateForm">
                    <!-- Input fields for updating profile data -->
                    <!-- You can customize this part based on your user table structure -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        // When profile update form is submitted
        $('#profileUpdateForm').on('submit', function (e) {
            e.preventDefault();

            // Perform AJAX update
            $.ajax({
                url: 'updateProfile.php', // Change this to the actual server-side script to update user profile
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    // Handle the response, e.g., show success message or handle errors
                    console.log(response);

                    // Close the modal
                    $('#changeProfileModal').modal('hide');
                },
                error: function (error) {
                    console.error('Error updating user profile:', error);
                    // Handle error as needed
                }
            });
        });
    });
</script>