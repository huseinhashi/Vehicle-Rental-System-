<?php
include 'include/header.php';
include 'include/db.php';

// Fetch all employees from the database
$query = "SELECT * FROM employees";
$result = mysqli_query($connection, $query);

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Employees</h4>
                    <p class="card-description">
                        <?php
                        $numEmployees = mysqli_num_rows($result);
                        echo "Employees in the system: " . $numEmployees . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addemployeemodal">Add New Employee</button>
                </div>
            </div>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Hire Date</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowColorClasses = ['table-info', 'table-warning', 'table-danger', 'table-success', 'table-primary'];

                        while ($row = mysqli_fetch_assoc($result)) {
                            $colorClass = $rowColorClasses[$counter % count($rowColorClasses)];
                            $counter++;
                            ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['full_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['email']; ?>
                                </td>
                                <td>
                                    <?php echo $row['contact_number']; ?>
                                </td>
                                <td>
                                    <?php echo $row['address']; ?>
                                </td>
                                <td>
                                    <?php echo $row['hire_date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['position']; ?>
                                </td>
                                <td>
                                    <?php echo '$' . $row['salary']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success editEmployeeBtn">Update</button>

                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteEmployeeModal(<?php echo $row['id']; ?>)">
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
<?php include 'components/add_employee_modal.php'; ?>
<?php include 'components/update_employee_modal.php'; ?>


<?php
include 'include/footer.php';
?>
<script>
    $(document).ready(function () {
        $('.editEmployeeBtn').on('click', function () {
            // Show the updateEmployeeModal
            $('#updateEmployeeModal').modal('show');
            // Get the closest <tr> ancestor of the clicked button
            $tr = $(this).closest('tr');

            // Extract data from the specific <td> elements in the selected row
            var id = $tr.find("td:eq(0)").text().trim();
            var full_name = $tr.find("td:eq(1)").text().trim();
            var email = $tr.find("td:eq(2)").text().trim();
            var contact_number = $tr.find("td:eq(3)").text().trim();
            var address = $tr.find("td:eq(4)").text().trim();
            var hire_date = $tr.find("td:eq(5)").text().trim();
            var position = $tr.find("td:eq(6)").text().trim();
            var salary = $tr.find("td:eq(7)").text().trim().replace('$', '');

            // Fill the input fields in the updateEmployeeModal with the extracted data
            $('#updateEmployeeId').val(id);
            $('#update_full_name').val(full_name);
            $('#update_email').val(email);
            $('#update_contact_number').val(contact_number);
            $('#update_address').val(address);
            $('#update_hire_date').val(hire_date);
            $('#update_position').val(position);
            $('#update_salary').val(salary);
        });
    });


</script>

<script>
    function deleteEmployeeModal(employeeId) {
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
                deleteEmployee(employeeId);
            }
        });
    }

    // Function to perform AJAX deletion
    function deleteEmployee(employeeId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_employee.php',
            data: { employeeId: employeeId },
            dataType: 'json',  // Expect JSON response
            success: function (response) {
                if (response.status === 'success') {
                    $('#employee_' + employeeId).remove();

                    // Display a success SweetAlert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Employee deleted successfully.',
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>