<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Detail</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>

    .custom-header {
            background-color: #000080; 
        }

   
    .card {
      height: auto;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: box-shadow 0.3s;
    }

    .card:hover {
      box-shadow: 0 0 11px rgba(33,33,33,.2);
    }

    .card-img-top {
      height: 300px;
      width: 100%;
      object-fit: cover;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
    }

    .card-body {
      padding: 15px;
    }

    .card-title {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .btn-container {
      text-align: center;
    }

    .badge-warning {
      background-color: #ffc107;
      color: #000;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="custom-header py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-2 text-center">
          <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle">
        </div>
        <div class="col-md-10 text-center text-md-left">
          <h1 class="text-white mb-0">Dil Fashion</h1>
          <p class="lead text-white mb-0">Your Fashion Destination</p>
        </div>
      </div>
    </div>
  </header>
  <!-- Header -->

  <div class="container mt-5">
    <h2 class="text-center mb-4">Inventory Detail</h2>

   
    <form action="" method="GET" class="mb-4">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search by Item ID or Item Name" name="search">
        <div class="input-group-append">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </div>
    </form>

    <?php
    include 'config.php';

    
    $categories = ["T-shirt", "Shirt", "Trousers","Short","Frock", "Blouse", "Skirt"];

    foreach ($categories as $category) {
        
        $sql = "SELECT itemId, itemName, itemPhoto, quantity FROM item WHERE category = '$category'";
        
       
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $conn->real_escape_string($_GET['search']);
            $sql .= " AND (itemId LIKE '%$search%' OR itemName LIKE '%$search%')";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<h3>' . $category . '</h3>';
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                // CheckING less than 50
                $quantity = $row['quantity'];
                $quantity_indicator = '';
                if ($quantity < 40) {
                    $quantity_indicator = '<span class="badge badge-warning">Low Stock</span>';
                }
                ?>
                <div class="col-md-4 mb-4">
                  <div class="card">
                    <a href="viewdetail.php?itemId=<?php echo $row['itemId']; ?>">
                      <img src="data:image/jpeg;base64,<?php echo base64_encode($row['itemPhoto']); ?>" class="card-img-top" alt="Item Photo">
                    </a>
                    <div class="card-body">
                      
                      <a href="viewdetail.php?itemId=<?php echo $row['itemId']; ?>" class="card-title">Item ID: <?php echo $row['itemId']; ?></a>
                      
                      <?php echo $quantity_indicator; ?>
                    </div>
                  </div>
                </div>
                <?php
            }
            echo '</div>';
        }
    }

    
    $conn->close();
    ?>
  </div>

  <div class="container mt-4 mb-5">
  <div class="row">
    <div class="col text-left mb-4">
      <a href="inventory.html" class="btn btn-success">Add Item</a>
    </div>
    <div class="col text-center mb-4">
      <a href="deleteinventory.html" class="btn btn-danger">Delete</a>
    </div>
    <div class="col text-center mb-4">
      <a href="inventoryreport.php" class="btn btn-info">Report</a> 
    </div>
    <div class="col text-right mb-4">
      <a href="home.html" class="btn btn-secondary">Back</a>
    </div>
  </div>
</div>
  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3 mt-5 footer">
    <div class="container">
        <p>© 2024 Employee Portal. All Rights Reserved.</p>
    </div>
  </footer>
  <!-- Footer -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
