<!-- add_salary_modal.php -->
<?php
// Include  database connection file
include '../include/db.php';

function getEmployees($connection)
{
    $sql = "SELECT id, full_name FROM employees";
    $result = $connection->query($sql);

    $employees = array();
    while ($row = $result->fetch_assoc()) {
        $employees[$row['id']] = $row['full_name'];
    }

    return $employees;
}

// $connection is now available for use

$allEmployees = getEmployees($connection);
?>

<!-- Modal HTML/PHP code -->
<div class="modal fade" id="addsalarymodal" tabindex="-1" role="dialog" aria-labelledby="addsalarymodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <form method="post" action="components/add_salary.php" onsubmit="return validateSalaryForm()"
                id="salaryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addsalarymodalLabel">Add Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="employee">Employee Name</label>
                        <select class="form-control" id="employee" name="employee" required>
                            <option value="" disabled selected>Choose Employee</option>
                            <?php
                            foreach ($allEmployees as $id => $full_name) {
                                echo "<option value=\"$id\">$full_name</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitSalaryForm()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function submitSalaryForm() {
        // Check if employee is selected
        const employeeSelect = document.getElementById('employee');
        if (!employeeSelect.value) {
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Form',
                text: 'Please select an employee before submitting.',
                confirmButtonText: 'OK',
            });
            return; // Stop form submission if employee is not selected
        }

        // Check if payment date is selected
        const paymentDateInput = document.getElementById('payment_date');
        const paymentDate = new Date(paymentDateInput.value);
        const currentDate = new Date();

        if (!paymentDateInput.value || paymentDate > currentDate.setHours(0, 0, 0, 0)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Payment Date',
                text: 'Please select a valid payment date.',
                confirmButtonText: 'OK',
            });
            return;
        }

        // Check if amount is provided
        const amountInput = document.getElementById('amount');
        if (!amountInput.value || isNaN(amountInput.value)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount',
                text: 'Please enter a valid amount.',
                confirmButtonText: 'OK',
            });
            return;
        }

        // Continue with form submission if all validations pass
        fetch('components/add_salary.php', {
            method: 'POST',
            body: new FormData(document.getElementById('salaryForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('salaryForm').reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Salary Registered!',
                        text: 'The salary has been successfully registered.',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Close the modal
                            $('#addsalarymodal').modal('hide');
                            // Reload the page
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to register the salary. Please try again.',
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
</script>