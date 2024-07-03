<?php

include 'config.php';


$sql = "SELECT itemId, quantity FROM item";
$result = $conn->query($sql);


$itemQuantities = [];


if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        
        $itemQuantities[$row['itemId']] = $row['quantity'];
    }
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
      
        .custom-header {
            background-color: #000080;
            padding-top: 30px; 
            padding-bottom: 20px;
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .header-logo {
            height: 50px; 
            margin-right: 10px;
        }
        .header-title {
            font-size: 2rem; 
            font-weight: bold;
            margin-bottom: 5px;
        }
        .sub-heading {
            font-size: 1.2rem;
            font-style: italic;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="custom-header">
        <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" class="header-logo">
        <h1 class="header-title">Dil Fashion</h1>
        <p class="sub-heading">Your Fashion Destination</p>
    </header>
    <!-- Header -->

    <!-- Body -->
    <div class="container mt-4 content">
        <div class="row">
            <div class="col-md-8">
                <!-- Inventory Report -->
                <div class="card mb-4">
                    <h5 class="card-header bg-primary text-white">Inventory Report</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    if (!empty($itemQuantities)) {
                                       
                                        foreach ($itemQuantities as $itemId => $quantity) {
                                           
                                            echo "<tr>";
                                            echo "<td>" . $itemId . "</td>";
                                            echo "<td>" . $quantity . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                       
                                        echo "<tr><td colspan='2'>No items found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
               
                <div class="card mb-4">
                    <h5 class="card-header bg-info text-white">Inventory Summary</h5>
                    <div class="card-body">
                        <?php
                       
                        if (!empty($itemQuantities)) {
                            
                            $totalItems = count($itemQuantities);
                            $totalQuantity = array_sum($itemQuantities);
                            $maxQuantity = max($itemQuantities);
                            $minQuantity = min($itemQuantities);
                            $maxItemId = array_search($maxQuantity, $itemQuantities);
                            $minItemId = array_search($minQuantity, $itemQuantities);

                           
                            echo "<p>Item ID count: " . $totalItems . "</p>";
                            echo "<p>Total Count: " . $totalQuantity . "</p>";
                            echo "<p>Highest Quantity: " . $maxQuantity . "</p>";
                            echo "<p>Highest Quantity Item ID: " . $maxItemId . "</p>";
                            echo "<p>Lowest Quantity: " . $minQuantity . "</p>";
                            echo "<p>Lowest Quantity Item ID: " . $minItemId . "</p>";
                        } else {
                            
                            echo "<p>No items found</p>";
                        }
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Body -->

    <!-- Bar Chart -->
    <div class="container mt-4 content">
        <div class="card">
            <div class="card-header bg-success text-white">Item Quantity Analysis</div>
            <div class="card-body">
                <canvas id="itemChart"></canvas>
            </div>
        </div>
    </div>

    
    <div class="container mt-4 content">
        <form action="detailpage.php" method="get">
            <button type="submit" class="btn btn-secondary">Go Back</button>
        </form>
    </div>

    
    <footer class="footer">
        <div class="container">
            <p>© 2024 Dil Fashion. All rights reserved.</p>
            <p>Contact: info@dilfashion.com</p>
        </div>
    </footer>
   

    <script>
        
        $(document).ready(function(){
           
            var itemQuantities = <?php echo json_encode($itemQuantities); ?>;
            
           
            var itemIds = Object.keys(itemQuantities);
            var quantities = Object.values(itemQuantities);

           
            var ctx = document.getElementById('itemChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: itemIds,
                    datasets: [{
                        label: 'Quantity',
                        data: quantities,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>