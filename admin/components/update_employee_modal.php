<!-- Update Employee Modal -->
<div class="modal fade" id="updateEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="updateEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEmployeeModalLabel">Update Employee Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="components/update_employee.php" method="POST" id="updateEmployeeForm">
                <div class="modal-body">

                    <input type="hidden" name="updateEmployeeId" id="updateEmployeeId">

                    <div class="form-group">
                        <label for="update_full_name">Full Name</label>
                        <input type="text" name="update_full_name" id="update_full_name" class="form-control"
                            placeholder="Enter Full Name">
                    </div>

                    <div class="form-group">
                        <label for="update_email">Email</label>
                        <input type="email" name="update_email" id="update_email" class="form-control"
                            placeholder="Enter Email">
                    </div>

                    <div class="form-group">
                        <label for="update_contact_number">Contact Number</label>
                        <input type="text" name="update_contact_number" id="update_contact_number" class="form-control"
                            placeholder="Enter Contact Number">
                    </div>

                    <div class="form-group">
                        <label for="update_address">Address</label>
                        <textarea name="update_address" id="update_address" class="form-control"
                            placeholder="Enter Address" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="update_hire_date">Hire Date</label>
                        <input type="date" name="update_hire_date" id="update_hire_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="update_position">Position</label>
                        <select name="update_position" id="update_position" class="form-control">
                            <?php foreach ($allPositions as $position): ?>
                                <option value="<?= $position['id'] ?>">
                                    <?= $position['position_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="update_salary">Salary</label>
                        <input type="number" step="0.01" name="update_salary" id="update_salary" class="form-control"
                            placeholder="Enter Salary">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUpdateEmployeeForm()">Update
                        Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission for updating an employee
    function submitUpdateEmployeeForm() {
        fetch('components/update_employee.php', {
            method: 'POST',
            body: new FormData(document.getElementById('updateEmployeeForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Employee Updated!',
                        text: 'The employee has been successfully updated.',
                    }).then(() => {
                        // Close the modal
                        $('#updateEmployeeModal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to update the employee. Please try again.');
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
            text: "succesfulyy Updated ",
        }).then(() => {
            location.reload();
        });
    }
</script>