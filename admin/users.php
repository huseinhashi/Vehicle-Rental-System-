<?php
include 'include/header.php';
include 'include/db.php';

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Users</h4>
                    <p class="card-description">
                        <?php
                        $numUsers = mysqli_num_rows($result);
                        echo "Users in the system: " . $numUsers . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addusermodal">
                        Add New User
                    </button>
                </div>
            </div>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
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
                                    <?php echo $row['username']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['role']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success edituserBtn">Update</button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteUserModal(<?php echo $row['id']; ?>)">
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

<!-- Include Add User Modal -->
<?php include 'components/add_user_modal.php'; ?>

<?php include 'include/footer.php'; ?>
<script>
    $(document).ready(function () {
        $('.edituserBtn').on('click', function () {
            // Show the updateUserModal
            $('#updateUserModal').modal('show');
            // Get the closest <tr> ancestor of the clicked button
            $tr = $(this).closest('tr');

            // Extract data from the specific <td> elements in the selected row
            var id = $tr.find("td:eq(0)").text().trim();
            var full_name = $tr.find("td:eq(1)").text().trim();
            var email = $tr.find("td:eq(2)").text().trim();
            var role = $tr.find("td:eq(3)").text().trim();

            // Fill the input fields in the updateUserModal with the extracted data
            $('#updateUserId').val(id);
            $('#update_username').val(full_name);
            $('#update_email').val(email);
            $('#update_role').val(role);
        });
    });
</script>
<script>
    // Function to handle SweetAlert confirmation and initiate deletion
    function deleteUserModal(userId) {
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
                deleteUser(userId);
            }
        });
    }

    // Function to perform AJAX deletion
    function deleteUser(userId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_user.php',
            data: { userId: userId },
            dataType: 'json',  // Expect JSON response
            success: function (response) {
                if (response.status === 'success') {
                    $('#user_' + userId).remove();

                    // Display a success SweetAlert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User deleted successfully.',
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
<?php include 'components/update_user_modal.php'; ?>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>