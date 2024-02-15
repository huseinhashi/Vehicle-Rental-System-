<?php
// Include your database connection file
include '../include/db.php';

function getCustomers($connection)
{
    $sql = "SELECT id, full_name FROM customers";
    $result = $connection->query($sql);

    $customers = array();
    while ($row = $result->fetch_assoc()) {
        $customers[$row['id']] = $row['full_name'];
    }

    return $customers;
}

function getAvailableVehicles($connection)
{
    $sql = "SELECT id, title, year, price FROM vehicles WHERE availability = 'available'";
    $result = $connection->query($sql);

    $vehicles = array();
    while ($row = $result->fetch_assoc()) {
        $vehicles[$row['id']] = [
            'title' => $row['title'],
            'year' => $row['year'],
            'price' => $row['price']
        ];
    }

    return $vehicles;
}

// $connection is now available for use

$allCustomers = getCustomers($connection);
$availableVehicles = getAvailableVehicles($connection);
?>

<!-- Modal HTML/PHP code -->
<div class="modal fade" id="addbookingmodal" tabindex="-1" role="dialog" aria-labelledby="addbookingmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <form method="post" action="components/add_booking.php" onsubmit="return validateForm()" id="bookingForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addbookingmodalLabel">Add Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customer">Customer Name</label>
                        <select class="form-control" id="customer" name="customer" required>
                            <option value="" disabled selected>Choose Customer</option>
                            <?php
                            foreach ($allCustomers as $id => $full_name) {
                                echo "<option value=\"$id\">$full_name</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="vehicle">Vehicle</label>
                        <select class="form-control" id="vehicle" name="vehicle" required>
                            <option value="" disabled selected>Choose vehicle</option>
                            <?php
                            foreach ($availableVehicles as $id => $vehicle) {
                                echo "<option value=\"$id\" data-price=\"{$vehicle['price']}\">{$vehicle['title']} ({$vehicle['year']})</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="return_date">Return Date</label>
                        <input type="date" class="form-control" id="return_date" name="return_date" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="price" name="price" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">USD</span>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="calculatePrice()">Calculate
                                    Price</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitBookingForm()">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function calculatePrice() {
        // Validate the start date
        const startDate = new Date(document.getElementById('start_date').value);
        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0); // Set time to midnight for comparison

        if (startDate < currentDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Start Date',
                text: 'Start date cannot be in the past. Please select a valid start date.',
                confirmButtonText: 'OK',
            });
            return;
        }

        // Continue with price calculation if the start date is valid
        const returnDate = new Date(document.getElementById('return_date').value);
        const vehicleSelect = document.getElementById('vehicle');
        const selectedVehiclePrice = parseFloat(vehicleSelect.options[vehicleSelect.selectedIndex].getAttribute('data-price'));

        // Calculate the price based on the date range and selected vehicle price
        const daysDifference = Math.ceil((returnDate - startDate) / (1000 * 60 * 60 * 24));
        const calculatedPrice = daysDifference * selectedVehiclePrice;

        // Set the calculated price in the readonly input field
        document.getElementById('price').value = calculatedPrice.toFixed(2);
    }


    document.getElementById('bookingForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Calculate the price based on the selected vehicle and date range
        const startDate = new Date(document.getElementById('start_date').value);
        const returnDate = new Date(document.getElementById('return_date').value);
        const vehicleSelect = document.getElementById('vehicle');
        const selectedVehicleId = vehicleSelect.value;
        const selectedVehiclePrice = parseFloat(vehicleSelect.options[vehicleSelect.selectedIndex].getAttribute('data-price'));

        // Calculate the price based on the date range and selected vehicle price
        const daysDifference = Math.ceil((returnDate - startDate) / (1000 * 60 * 60 * 24));
        const calculatedPrice = daysDifference * selectedVehiclePrice;

        // Set the calculated price in the readonly input field
        document.getElementById('price').value = calculatedPrice.toFixed(2);

        submitBookingForm();
    });

    function submitBookingForm() {

        // Check if customer is selected
        const customerSelect = document.getElementById('customer');
        if (!customerSelect.value) {
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Form',
                text: 'Please select a customer before submitting.',
                confirmButtonText: 'OK',
            });
            return; // Stop form submission if customer is not selected
        }

        // Check if vehicle is selected
        const vehicleSelect = document.getElementById('vehicle');
        if (!vehicleSelect.value) {
            Swal.fire({
                icon: 'error',
                title: 'Incomplete Form',
                text: 'Please select a vehicle before submitting.',
                confirmButtonText: 'OK',
            });
            return; // Stop form submission if vehicle is not selected
        }
        // Check if start date is selected
        const startDateInput = document.getElementById('start_date');
        const startDate = new Date(startDateInput.value);
        const currentDate = new Date();

        if (!startDateInput.value || startDate < currentDate.setHours(0, 0, 0, 0)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Start Date',
                text: 'Please select a valid start date.',
                confirmButtonText: 'OK',
            });
            return; // Stop form submission if start date is not selected or in the past
        }

        // Check if return date is selected
        const returnDateInput = document.getElementById('return_date');
        const returnDate = new Date(returnDateInput.value);

        if (!returnDateInput.value || returnDate <= startDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Return Date',
                text: 'Please select a valid return date after the start date.',
                confirmButtonText: 'OK',
            });
            return; // Stop form submission if return date is not selected or before start date
        }

        // Continue with form submission if all validations pass
        fetch('components/add_booking.php', {
            method: 'POST',
            body: new FormData(document.getElementById('bookingForm')),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('bookingForm').reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Registered!',
                        text: 'The booking has been successfully registered.',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Close the modal
                            $('#addbookingmodal').modal('hide');

                            // Update the table dynamically (you may need to implement this)
                            // This could involve appending a new row to the table without a full page reload.

                            // Alternatively, reload the page
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to register the booking. Please try again.',
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