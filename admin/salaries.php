<?php
include 'include/header.php';
include 'include/db.php';

// Fetch all salaries from the database
$query = "SELECT * FROM salaries";
$result = mysqli_query($connection, $query);

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Salaries</h4>
                    <p class="card-description">
                        <?php
                        $numSalaries = mysqli_num_rows($result);
                        echo "Salaries in the system: " . $numSalaries . "+";
                        ?>
                    </p>
                </div>
                <div>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addsalarymodal">
                        Register Salary
                    </button>

                </div>
            </div>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
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
                                    <?php echo $row['employee_full_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['payment_date']; ?>
                                </td>
                                <td>
                                    <?php echo '$ ' . $row['amount']; ?>
                                </td>
                                <td>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'components/add_salary_modal.php'; ?>


<?php include 'include/footer.php'; ?>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>