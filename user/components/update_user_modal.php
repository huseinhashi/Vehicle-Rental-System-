<!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Update User Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="components/update_user.php" method="POST" id="updateUserForm">
                <div class="modal-body">

                    <input type="hidden" name="updateUserId" id="updateUserId">

                    <div class="form-group">
                        <label for="update_username">Username</label>
                        <input type="text" name="update_username" id="update_username" class="form-control"
                            placeholder="Enter Username">
                    </div>

                    <div class="form-group">
                        <label for="update_email">Email</label>
                        <input type="email" name="update_email" id="update_email" class="form-control"
                            placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="update_role">Role</label>
                        <select name="update_role" id="update_role" class="form-control">
                            <!-- Assuming you have predefined roles -->
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUpdateUserForm()">Update
                        Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission for updating a user
    function submitUpdateUserForm() {
        fetch('components/update_user.php', {
            method: 'POST',
            body: new FormData(document.getElementById('updateUserForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'User Updated!',
                        text: 'The user has been successfully updated.',
                    }).then(() => {
                        // Close the modal
                        $('#updateUserModal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to update the user. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Display SweetAlert for unexpected error
                showError('An unexpected error occurred. Please try again.');
            });
    }
</script>