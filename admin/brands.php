<?php
include 'include/header.php';
include 'include/db.php';
include 'components/add_brand_modal.php';

// Fetch all brands from the database
$query = "SELECT * FROM brands";
$result = mysqli_query($connection, $query);

// Counter for unique IDs
$counter = 0;
?>

<div class="col-lg-12 stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title">Brands </h4>
                    <p class="card-description">
                        <?php
                        $numbrands = mysqli_num_rows($result);
                        echo "Brands  are in the system: " . $numbrands . "+";
                        ?>
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrandModal">
                        Add New Brand
                    </button>
                </div>
            </div>
            <div class="table-responsive pt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowColorClasses = [''];

                        while ($row = mysqli_fetch_assoc($result)) {
                            $colorClass = $rowColorClasses[$counter % count($rowColorClasses)];
                            $counter++;
                            ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['name']; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success editBrandBtn">Update</button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        onclick="deleteBrand(<?php echo $row['id']; ?>)">
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
include 'components/update_brand_modal.php';

?>
<script>
    $(document).ready(function () {
        $('.editBrandBtn').on('click', function () {
            // Show the updateEmployeeModal
            $('#updateBrandModal').modal('show');
            // Get the closest <tr> ancestor of the clicked button
            $tr = $(this).closest('tr');

            // Extract data from the specific <td> elements in the selected row
            var id = $tr.find("td:eq(0)").text().trim();
            var name = $tr.find("td:eq(1)").text().trim();
            // Fill the input fields in the updateBrandModal with the extracted data
            $('#updateBrandId').val(id);
            $('#update_name').val(name);
        });
    });


</script>
<script>
    // Add brand form submission
    $('#addBrandForm').submit(function (e) {
        e.preventDefault();

        // Perform AJAX request to add brand
        $.ajax({
            type: 'POST',
            url: 'components/add_brand.php',
            data: $(this).serialize(),
            success: function (response) {
                console.log(response);
            }
        });

        // Close the modal
        $('#addBrandModal').modal('hide');
    });
    // Function to open delete brand confirmation modal
    function deleteBrand(brandId) {
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
                deleteBrandAjax(brandId);
            }
        });
    }

    // AJAX request to delete brand
    // AJAX request to delete brand
    function deleteBrandAjax(brandId) {
        $.ajax({
            type: 'POST',
            url: 'components/delete_brand.php',
            data: { brandId: brandId },
            success: function (response) {
                if (response.status === 'success') {
                    // Find the closest table row and remove it
                    $('button[data-id="' + brandId + '"]').closest('tr').remove();

                    // Display a success SweetAlert
                    Swal.fire('Deleted!', 'Brand deleted successfully.', 'success');
                } else {
                    // Display a success SweetAlert
                    Swal.fire('Deleted!', 'Brand  deleted successfully.', 'success').then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload();
                        }
                    });
                }
            },
        });
    }

</script>