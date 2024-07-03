<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="bill.css">
</head>
<style>
    body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

    footer {
        margin-top: auto;
    }


</style>

<body>
    <div class="d-flex flex-column">
    <header class="bg-light p-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle">
                </div>
                <div class="col-md-8 text-center">
                    <h2 class="text-uppercase font-weight-bold"><i class="fas fa-shopping-bag"></i> Dil Fashion</h2>
                    <p class="lead text-white mb-0">Your Fashion Destination</p>
                    <p id="shopInfo" class="lead"></p>
                </div>
                <div class="col-md-2">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="month">Select Month:</label>
                            <input type="month" class="form-control" id="month" name="month">
                        </div>
                        <button type="submit" class="btn btn-primary" name="generate">Generate Report</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
        
    </div>

    <div class="container mt-5">

        <?php
        include_once 'config.php';

        if(isset($_POST['generate'])) {

            $month = $_POST['month'];

            $sql = "SELECT s.name, SUM(b.total_amount) AS total_amount FROM bill b
                INNER JOIN shop s ON b.shopId = s.shopId
                WHERE MONTH(b.create_date) = MONTH('$month-01')
                GROUP BY s.name";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $salesData = [];
                    $shops = [];
                    $totalAmounts = [];

                    while($row = mysqli_fetch_assoc($result)) {
                        $salesData[$row['name']] = $row['total_amount'];
                        $shops[] = $row['name'];
                        $totalAmounts[] = $row['total_amount'];
                    }

                    $maxSalesShop = array_search(max($totalAmounts), $salesData);
                    $minSalesShop = array_search(min($totalAmounts), $salesData);

                    echo "<h2 class='text-center mb-4'>All Shop bill Details for $month</h2>";

                    foreach ($shops as $shopName) {
                        $sql = "SELECT * FROM shop WHERE name = '$shopName'";
                        $result = mysqli_query($conn, $sql);
        
                        if (mysqli_num_rows($result) > 0) {
                            $shop = mysqli_fetch_assoc($result);
                            $shopId = $shop['shopId'];
        
                            $sql = "SELECT * FROM bill WHERE shopId = '$shopId'";
                            $result = mysqli_query($conn, $sql);
        
                            if (mysqli_num_rows($result) > 0) {
                                echo '<div class="mt-5">';
                                echo '<h4 class="text-center">' . $shopName . ' Bill Details</h4>';
                                echo '<table class="table table-bordered">';
                                echo '<thead><tr><th>Bill ID</th><th>Bill Total Amount(Rs.)</th><th>Bill Date and Time</th></tr></thead>';
                                echo '<tbody>';
        
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['bill_id'] . '</td>';
                                    echo '<td>' . number_format($row['total_amount'], 2) . '</td>';
                                    echo '<td>' . $row['create_date']. '</td>';
                                    echo '</tr>';
                                }
        
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo '<div class="mt-5">';
                                echo '<h4 class="text-center">No Bills Found for ' . $shopName . '</h4>';
                                echo '</div>';
                            }
                        }
                    }

                    // Calculate total sales for garment store
                    $sql_total_sales = "SELECT SUM(total_amount) AS total_sales FROM bill WHERE MONTH(create_date) = MONTH('$month-01')";
                    $result_total_sales = mysqli_query($conn, $sql_total_sales);
                    $total_sales = 0;
                    if ($result_total_sales && mysqli_num_rows($result_total_sales) > 0) {
                        $row_total_sales = mysqli_fetch_assoc($result_total_sales);
                        $total_sales = $row_total_sales['total_sales'];
                    }

                    echo '<div class="mt-3">
                            <span class="text-center" style="font-size: 1.2em;"><b>Total Sales for Garment Store (Rs.)  :</b></span>
                            <span style="font-size: 1.2em;">'.number_format($total_sales, 2).'</span>
                          </div>';


                    echo '<div class="mt-3">
                          <span class="text-center" style="font-size: 1.2em;"><b>Maximum Sales Shop:</b></span>
                          <span style="font-size: 1.2em;">'.$maxSalesShop.'</span>
                         </div>';
                
                  echo '<div class="mt-3">
                          <span class="text-center" style="font-size: 1.2em;"><b>Minimum Sales Shop:</b></span>
                          <span style="font-size: 1.2em;">'.$minSalesShop.'</span>
                        </div>';

                    echo '<div class="mt-5">
                            <h4 class="text-center">Monthly Sales Report</h4>
                            <canvas id="salesChart"></canvas>
                          </div>';

                    
                    //pie chart
                    echo '<script> 
                            var ctx = document.getElementById("salesChart").getContext("2d");
                            var salesChart = new Chart(ctx, {
                                type: "pie",
                                data: {
                                    labels: '.json_encode($shops).',
                                    datasets: [{
                                        label: "Total Amount",
                                        data: '.json_encode($totalAmounts).',
                                        backgroundColor: [
                                            "rgba(255, 99, 132, 0.2)",
                                            "rgba(54, 162, 235, 0.2)",
                                            "rgba(255, 206, 86, 0.2)",
                                            "rgba(75, 192, 192, 0.2)",
                                            "rgba(153, 102, 255, 0.2)"
                                        ],
                                        borderColor: [
                                            "rgba(255, 99, 132, 1)",
                                            "rgba(54, 162, 235, 1)",
                                            "rgba(255, 206, 86, 1)",
                                            "rgba(75, 192, 192, 1)",
                                            "rgba(153, 102, 255, 1)"
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    cutoutPercentage: 10 // Adjust the size of the circle (0 to 100)
                                }
                            });
                          </script>';

                } else {
                    echo "No data found for the selected month.";
                }
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
        ?>
    </div>
    <br>
    <br>
    <br>
    <footer class="bg-dark text-white text-center py-3 footer">
        <div class="container">
            <p>© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>
