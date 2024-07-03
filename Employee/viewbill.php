<?php
include 'config.php';

if (isset($_GET['billId'])) {
    $billId = $_GET['billId'];

    $shopNameSql = "SELECT name 
                    FROM shop  
                    INNER JOIN bill ON shop.shopId = bill.shopId 
                    WHERE bill_id = $billId";
    $shopNameResult = mysqli_query($conn, $shopNameSql);

    if (!$shopNameResult) {
        die('Error fetching shop name: ' . mysqli_error($conn));
    }

    $shopNameRow = mysqli_fetch_assoc($shopNameResult);
    $shopName = $shopNameRow['name'];

    $shopIDSql = "SELECT shopId
                  FROM bill
                  WHERE bill_id = $billId";
    $shopIDResult = mysqli_query($conn, $shopIDSql);

    if (!$shopIDResult) {
        die('Error fetching shop ID: ' . mysqli_error($conn));
    }

    $shopIDRow = mysqli_fetch_assoc($shopIDResult);
    $shopId = $shopIDRow['shopId'];

    $sql = "SELECT item.itemId, item.itemName, bill_details.quantity, item.price, (item.price * bill_details.quantity) AS total
            FROM bill_details
            INNER JOIN item ON bill_details.itemId = item.itemId
            INNER JOIN bill ON bill_details.bill_Id = bill.bill_Id
            WHERE bill.bill_Id = $billId";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error fetching bill details: ' . mysqli_error($conn));
    }

    $grandTotal = 0;

    if (isset($_GET['download']) && $_GET['download'] == 'true') {
        require('./fpdf/fpdf.php');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Shop Name: ' . $shopName, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(25, 10, 'Item ID', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Item Name', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Quantity', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Unit Price(LKR)', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total(LKR)', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 12);
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(25, 10, $row['itemId'], 1, 0, 'C');
            $pdf->Cell(50, 10, $row['itemName'], 1, 0, 'L');
            $pdf->Cell(30, 10, $row['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($row['price'], 2), 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($row['total'], 2), 1, 1, 'C');
            $grandTotal += $row['total'];
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(145, 10, 'Grand Total:', 0, 0, 'R');
        $pdf->Cell(40, 10, number_format($grandTotal, 2), 1, 1, 'C');

        $pdf->Output('D', 'bill_invoice.pdf');
        exit;
    }
} else {
    die('No bill ID provided.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bill - <?php echo $shopName; ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="viewbill.css">
</head>

<body class="d-flex flex-column">
    <header class="bg-light p-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid">
                </div>
                <div class="col-md-8 text-center">
                    <h2 class="text-uppercase font-weight-bold"><i class="fas fa-shopping-bag"></i> <?php echo $shopName; ?></h2>
                    <p class="lead text-white mb-0">Your Fashion Destination</p>
                    <p id="shopInfo" class="lead"></p>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shopId"><i class="fas fa-store"></i> Shop ID</label>
                        <input type="text" class="form-control" id="shopId" placeholder="Enter Shop ID" value="<?php echo $shopId; ?>">
                    </div>
                    <div class="form-group">
                        <label for="shopName"><i class="fas fa-store-alt"></i> Shop Name</label>
                        <input type="text" class="form-control" id="shopName" readonly value="<?php echo $shopName; ?>">
                    </div>
                    
                </div>
            </div>
        </div>
    </header>

    <div class="flex-grow-1">
        <div class="container mt-5">
            <h3 class="text-center mb-4">Bill Details</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="billTableBody">
                <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $grandTotal += $row['total'];
                        echo "<tr>";
                        echo "<td>{$row['itemId']}</td>";
                        echo "<td>{$row['itemName']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td>{$row['total']}</td>";
                        echo "<td>";
                        echo "<button class='btn btn-sm btn-primary mr-2' onclick='updateItem({$row['itemId']})'>Update</button>";
                        echo "<button class='btn btn-sm btn-danger' onclick='deleteItem({$row['itemId']})'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                        <td id="grandTotal" class="font-weight-bold">
                            <?php echo number_format($grandTotal, 2); ?>
                        </td>
                        <td></td> 
                    </tr>
                </tfoot>
            </table>
            <div class="text-right">
                <a href="viewbill.php?billId=<?php echo $billId; ?>&download=true" class="btn btn-primary"><i class="fas fa-download"></i> Download Bill as PDF</a>
            </div>
            <br>
            <br>
            <div class="row">
            <div class="col-md-6 text-left">
                <a href="bill.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Go Back</a>
            </div>
            <div class="col-md-6 text-right">
                <a href="bill.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Another Bill</a>
            </div>
        </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p>© 2024 <?php echo $shopName; ?>. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function updateItem(itemId) {
            var newQuantity = prompt("Enter new quantity:");
            if (newQuantity !== null) {
                $.ajax({
                    url: 'update_item.php',
                    type: 'POST',
                    data: { itemId: itemId, quantity: newQuantity },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function deleteItem(itemId) {
            if (confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                    url: 'delete_item.php',
                    type: 'POST',
                    data: { itemId: itemId },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>
</body>

</html>

<?php
$updateTotalSql = "UPDATE bill SET total_amount = $grandTotal WHERE bill_id = $billId";
mysqli_query($conn, $updateTotalSql);
?>
