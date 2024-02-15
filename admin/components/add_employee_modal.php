<?php
include '../include/db.php';

function getPositions($connection)
{
    $sql = "SELECT id, position_name FROM positions";
    $result = $connection->query($sql);

    $positions = array();
    while ($row = $result->fetch_assoc()) {
        $positions[] = $row; // Store the entire row for each position
    }

    return $positions;
}
$allPositions = getPositions($connection);
?>

<!-- Modal HTML/PHP code for Add Employee -->
<div class="modal fade" id="addemployeemodal" tabindex="-1" role="dialog" aria-labelledby="addemployeemodalLabel"
    aria-hidden="">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <!-- Include the form for adding a new Employee -->
            <form method="post" action="components/add_employee.php" onsubmit="return validateEmployeeForm()"
                id="employeeForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addemployeemodalLabel">Add Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                        <small id="fullNameError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <small id="emailError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                        <small id="contactNumberError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        <small id="addressError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="hire_date">Hire Date</label>
                        <input type="date" class="form-control" id="hire_date" name="hire_date" required>
                        <small id="hireDateError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <select class="form-control" id="position" name="position" required>
                            <?php foreach ($allPositions as $position): ?>
                                <option value="<?= $position['id'] ?>">
                                    <?= $position['position_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small id="positionError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
                        <small id="salaryError" class="text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitEmployeeForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Function to handle form submission for adding an employee
    function submitEmployeeForm() {
        fetch('components/add_employee.php', {
            method: 'POST',
            body: new FormData(document.getElementById('employeeForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Employee Added!',
                        text: 'The employee has been successfully added.',
                    }).then(() => {
                        // Close the modal
                        $('#addemployeemodal').modal('hide');
                        // Optionally, refresh the page
                        location.reload();
                    });
                } else {
                    // Display SweetAlert for error
                    showError('Failed to add the employee. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Display SweetAlert for unexpected error
                showError('An unexpected error occurred. Please try again.');
            });
    }
</script>