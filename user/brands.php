<?php
include 'include/header.php';
include 'include/db.php';
// Fetch all customers from the database
$query = "SELECT * FROM brands";
$result = mysqli_query($connection, $query);

// Include the Add Customer Modal
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowColorClasses = ['table-warning'];

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