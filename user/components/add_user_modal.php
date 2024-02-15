<!-- add_user_modal.php -->
<?php
// Include  database connection file
include '../include/db.php';
?>

<!-- Modal HTML/PHP code -->
<div class="modal fade" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="addusermodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <form method="post" action="components/add_user.php" onsubmit="return validateForm()" id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addusermodalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUserForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission
    function submitUserForm() {
        // Validate the form
        if (validateForm()) {
            fetch('components/add_user.php', {
                method: 'POST',
                body: new FormData(document.getElementById('userForm')),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('userForm').reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'User Added!',
                            text: 'The user has been successfully added.',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Close the modal
                                $('#addusermodal').modal('hide');

                                // Reload the page
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add the user. Please try again.',
                            confirmButtonText: 'OK',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.',
                        confirmButtonText: 'OK',
                    });
                });
        }
    }

    // Function to validate the form
    function validateForm() {
        // Get form elements
        var username = document.getElementById('username').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var role = document.getElementById('role').value;
        var full_name = document.getElementById('full_name').value.trim();
        var contact_number = document.getElementById('contact_number').value.trim();
        var address = document.getElementById('address').value.trim();

        // Validate required fields
        if (username === '' || email === '' || password === '' || role === '' || full_name === '' || contact_number === '' || address === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'All fields are required.',
                confirmButtonText: 'OK',
            });
            return false;
        }

        return true; // Form is valid
    }

</script>