<?php
include 'include/header.php';
include 'include/db.php';

// Fetch all customers from the database
$query = "SELECT * FROM customers";
$result = mysqli_query($connection, $query);

// Include the Add Customer Modal
include 'components/add_customer_modal.php';
include 'components/update_customer_modal.php';
// include 'components/delete_customer_modal.php';

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">All Customers</h4>
                    <p class="card-description">
                        <?php
                        $numCustomers = mysqli_num_rows($result);
                        echo "Customers are in the system: " . $numCustomers . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addCustomerModal">Add New Customer</button>
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
                                    <button type="button" class="btn btn-success editCustomerBtn">Update</button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteCustomerModal(<?php echo $row['id']; ?>)">
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


<?php
include 'include/footer.php';
?>
<?php include 'components/update_customer_modal.php'; ?>
<script>
    $(document).ready(function () {
        $('.editCustomerBtn').on('click', function () {
            // Show the updateCustomerModal
            $('#updateCustomerModal').modal('show');
            // Get the closest <tr> ancestor of the clicked button
            $tr = $(this).closest('tr');

            // Extract data from the specific <td> elements in the selected row
            var id = $tr.find("td:eq(0)").text().trim();
            var full_name = $tr.find("td:eq(1)").text().trim();
            var email = $tr.find("td:eq(2)").text().trim();
            var contact_number = $tr.find("td:eq(3)").text().trim();
            var address = $tr.find("td:eq(4)").text().trim();

            // Fill the input fields in the updateCustomerModal with the extracted data
            $('#updateCustomerId').val(id);
            $('#update_full_name_customer').val(full_name);
            $('#update_email_customer').val(email);
            $('#update_contact_number_customer').val(contact_number);
            $('#update_address_customer').val(address);
        });
    });
</script>

<script>
    function deleteCustomerModal(customerId) {
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
                deleteCustomerAjax(customerId);
            }
        });
    }

    // AJAX request to delete customer
    function deleteCustomerAjax(customerId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_customer.php',
            data: { customerId: customerId },
            success: function (response) {
                if (response.status === 'success') {
                    // Assuming the row ID is used to identify the customer in the HTML
                    $('#customer_' + customerId).remove();

                    // Display a success SweetAlert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Customer deleted successfully.',
                        icon: 'success',
                    }).then((result) => {
                        // Reload the page when the user clicks "OK"
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload();
                        }
                    });
                } else {
                    // Display a success SweetAlert
                    Swal.fire('Deleted!', 'Customer deleted successfully.', 'success').then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload();
                        }
                    });
                }
            },
        });
    }
</script>
<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>