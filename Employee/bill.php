<?php

require_once('config.php');
$queary = "SELECT * FROM item";
$result = mysqli_query($conn, $queary);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dil Fashion Bill Page</title>
   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
   
    <link rel="stylesheet" href="bill.css">
</head>

<body class="d-flex flex-column">

 
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
                    <div class="form-group">
                        <label for="shopId"><i class="fas fa-store"></i> Shop ID</label>
                        <input type="text" class="form-control" id="shopId" placeholder="Enter Shop ID">
                    </div>
                    <div class="form-group">
                        <label for="shopName"><i class="fas fa-store-alt"></i> Shop Name</label>
                        <input type="text" class="form-control" id="shopName" readonly>
                    </div>
                    <div class="form-group text-left">
                        <a href="salesReport.php" class="btn btn-info"><i class="fas fa-chart-line"></i> Sales Report</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>


    
    <div class="flex-grow-1">
        <div class="container mt-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><i class="fas fa-barcode"></i> Item ID</th>
                        <th><i class="fas fa-tag"></i> Item Name</th>
                        <th><i class="fas fa-sort-amount-up"></i> Quantity</th>
                        <th><i class="fas fa-dollar-sign"></i> Unit Price</th>
                        <th><i class="fas fa-money-bill-wave"></i> Total</th>
                        <th><i class="fas fa-trash-alt"></i> Action</th>
                    </tr>
                </thead>
                <tbody id="checkoutTableBody">
                  
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                        <td id="grandTotal" class="font-weight-bold">0.00</td>
                    </tr>
                </tfoot>
            </table>

           
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="itemId"><i class="fas fa-barcode"></i> Item ID</label>
                        <input type="text" class="form-control" id="itemId" placeholder="Enter Item ID" onchange="populateItemDetails()">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="itemName"><i class="fas fa-tag"></i> Item Name</label>
                        <input type="text" class="form-control" id="itemName" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="unitPrice"><i class="fas fa-dollar-sign"></i> Unit Price</label>
                        <input type="text" class="form-control" id="unitPrice" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="quantity"><i class="fas fa-sort-amount-up"></i> Quantity</label>
                        <input type="number" class="form-control" id="quantity"  min="0" value="0" placeholder="Enter Quantity">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block" onclick="addItem()"><i class="fas fa-plus"></i> Add Item</button>
                </div>
            </div>
            <br>

            <hr>
            <br>

            <h4> Item Details</h4>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th> Item ID</th>
                        <th> Item Name</th>
                        <th> Item Material</th>
                        <th> Item Quantity'</th>
                        <th> Unit Price</th>
                        
                    </tr>
                </thead>
                <tbody id="checkoutTableBody">
                   
                </tbody>
                <tfoot>
                    <tr>
                        <?php

                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$row['itemId']}</td>";
                                echo "<td>{$row['itemName']}</td>";
                                echo "<td>{$row['material']}</td>";
                                echo "<td>{$row['quantity']}</td>";
                                echo "<td>{$row['price']}</td>";
                                echo "</tr>";
                            }

                        ?>
                        
                    </tr>
                </tfoot>
            </table>



           
            <form method="post">
             
                <input type="hidden" id="shopIdHidden" name="shopId" value="">
               
                <div class="row mt-3">
                    <div class="col-md-6 text-left">
                        <a href="home.html" class="btn btn-secondary"><i class="fas fa-home"></i> Back to Home</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary" onclick="submitBill()"><i class="fas fa-paper-plane"></i> Submit</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
    <br>
    
    <footer class="bg-dark text-white text-center py-3 footer">
        <div class="container">
            <p>© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script>
        
        function populateItemDetails() {
            var itemId = $('#itemId').val();

           
            $.ajax({
                url: 'get_item_details.php',
                type: 'POST',
                data: { itemId: itemId },
                dataType: 'json',
                success: function (response) {
                   
                    $('#itemName').val(response.itemName);
                    $('#unitPrice').val(response.price);
                },
                error: function (xhr, status, error) {
                    
                    console.error(xhr.responseText);
                }
            });
        }

        function calculateTotal() {
            var grandTotal = 0;

            for (var i = 0; i < addedItems.length; i++) {
                var item = addedItems[i];
                grandTotal += item.quantity * parseFloat($('#unitPrice').val());
            }

          
            $('#grandTotal').text(grandTotal.toFixed(2));
        }

        var addedItems = [];

        function addItem() {
            var itemId = $('#itemId').val();
            var itemName = $('#itemName').val();
            var unitPrice = parseFloat($('#unitPrice').val());
            var quantity = parseInt($('#quantity').val());

           
            if (!itemId || !itemName || isNaN(unitPrice) || isNaN(quantity) || quantity <= 0 || !Number.isInteger(quantity)) {
                alert('Please enter a valid item quantity');
                return;
            }

           
            $.ajax({
                url: 'check_item_quantity.php',
                type: 'POST',
                data: { itemId: itemId, quantity: quantity },
                dataType: 'json',
                success: function(response) {
                    if (response.valid) {
                        var total = unitPrice * quantity;

                     
                        addedItems.push({ itemId: itemId, quantity: quantity });

                        $.ajax({
                            url: 'reduce_item_quantity.php',
                            type: 'POST',
                            data: { itemId: itemId, quantity: quantity },
                            dataType: 'json',
                            success: function(response) {
                              
                                console.log(response.message);
                            },
                            error: function(xhr, status, error) {
                               
                                console.error(xhr.responseText);
                            }
                        });

                        
                        var newRow = $('<tr>');
                        newRow.append('<td>' + itemId + '</td>');
                        newRow.append('<td>' + itemName + '</td>');
                        newRow.append('<td>' + quantity + '</td>');
                        newRow.append('<td>' + unitPrice.toFixed(2) + '</td>');
                        newRow.append('<td>' + total.toFixed(2) + '</td>');
                        newRow.append('<td><button class="btn btn-danger btn-sm" onclick="removeItem(this)"><i class="fas fa-trash-alt"></i></button></td>');

                       
                        $('#checkoutTableBody').append(newRow);

                       
                        calculateTotal();
                    } else {
                        alert('Quantity exceeds available quantity for this item.');
                    }
                },
                error: function(xhr, status, error) {
                    
                    console.error(xhr.responseText);
                }
            });
        }


        function removeItem(button) {
            
            $(button).closest('tr').remove();

            
            calculateTotal();
        }

        function backToHome() {
           
            console.log('Back to home button clicked');
        }

        function submitBill() {
            var shopId = $('#shopId').val();

            $.ajax({
                url: 'create_bill.php',
                type: 'POST',
                data: { shopId: shopId, items: addedItems },
                dataType: 'json',
                success: function(response) {
                  
                    console.log(response);

                   
                    if (response.success) {
                        alert('Bill created successfully');
                        
                        window.location.href = 'viewbill.php?billId=' + response.billId;
                    } else {
                        alert('Failed to create bill');
                    }
                },
                error: function(xhr, status, error) {
                   
                    console.error(xhr.responseText);
                    alert('Failed to create bill');
                }
            });
        }




         $(document).ready(function() {
            $('#shopId').on('input', function() {
                var shopId = $(this).val();
                fetchShopName(shopId);
            });
        });

        function fetchShopName(shopId) {
            $.ajax({
                url: 'fetch_shop_name.php',
                type: 'POST',
                data: {shopId: shopId},
                success: function(response) {
                    $('#shopName').val(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
         });
}
    </script>

</body>

</html>