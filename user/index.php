<?php
include 'include/header.php';
include 'include/db.php';
$loggedInUser = $_SESSION['username'];
function getTotalBrands($connection)
{
  $sql = "SELECT COUNT(*) AS total_brands FROM brands";
  $result = $connection->query($sql);
  $row = $result->fetch_assoc();
  return $row['total_brands'];
}

// Function to get total vehicles
function getTotalVehicles($connection)
{
  $sql = "SELECT COUNT(*) AS total_vehicles FROM vehicles";
  $result = $connection->query($sql);
  $row = $result->fetch_assoc();
  return $row['total_vehicles'];
}

// Function to get total customers
function getTotalCustomers($connection)
{
  $sql = "SELECT COUNT(*) AS total_customers FROM customers";
  $result = $connection->query($sql);
  $row = $result->fetch_assoc();
  return $row['total_customers'];
}

// Function to get total employees
function getTotalBookings($connection)
{
  $sql = "SELECT COUNT(*) AS total_bookings FROM bookings";
  $result = $connection->query($sql);
  $row = $result->fetch_assoc();
  return $row['total_bookings'];
}


// Get total counts
$totalBrands = getTotalBrands($connection);
$totalVehicles = getTotalVehicles($connection);
$totalCustomers = getTotalCustomers($connection);
$totalBookings = getTotalBookings($connection);

// Close the database connection
$connection->close();
?>


<div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="row">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
          <h3 class="font-weight-bold">Welcome
            <?php echo $loggedInUser; ?>
          </h3>
          <h6 class="font-weight-normal mb-0">User Dashboard <span class="text-primary">Dalka Rentals</span></h6>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card tale-bg">
        <div class="card-people mt-auto">
          <img src="images/dashboard/1.png" alt="people">
          <div class="weather-info">
            <div class="d-flex">
              <div>
                <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
              </div>
              <div class="ml-2">
                <h4 class="location font-weight-normal">Mogadisho</h4>
                <h6 class="font-weight-normal">Somalia</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin transparent">
      <div class="row">
        <div class="col-md-6 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <p class="mb-4">Total Brands</p>
              <p class="fs-30 mb-2">
                <?php echo $totalBrands; ?>
              </p>
              <p>10.00% (30 days)</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <p class="mb-4">Total Vehicles</p>
              <p class="fs-30 mb-2">
                <?php echo $totalVehicles; ?>
              </p>
              <p>22.00% (30 days)</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
          <div class="card card-light-blue">
            <div class="card-body">
              <p class="mb-4">Total Customers</p>
              <p class="fs-30 mb-2">
                <?php echo $totalCustomers; ?>
              </p>
              <p>2.00% (30 days)</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 stretch-card transparent">
          <div class="card card-light-danger">
            <div class="card-body">
              <p class="mb-4"> Bookings</p>
              <p class="fs-30 mb-2">
                <?php echo $totalBookings; ?>
              </p>
              <p>0.22% (30 days)</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php


include 'include/footer.php'

  ?>