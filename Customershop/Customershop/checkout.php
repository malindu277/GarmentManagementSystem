<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Page</title>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      background-image : url('product_images/shopping-07.jpg');
    }

    .main-container {
      display: flex;
      align-items: center;
    }

    .container-1 {
      flex: 1;
    }

    .container {
      flex: 4;
    }

    .cart-card {
        border: 1px solid #ccc; 
        border-radius: 8px; 
        padding: 10px; 
        margin-bottom: 20px; 
        background-color: white;
    }

    .cart-item {
        display: flex;
        align-items: center;
    }

    .image-container {
        flex: 1; 
    }

    .item-image {
        width: 100px; 
        height: auto; 
        margin-right: 20px; 
    }

    .details-container {
        flex: 4; 
    }

    .item-name {
        font-weight: bold;
    }

    .item-quantity,
    .item-price {
        margin-top: 5px;
    }

    .item-price {
        font-weight: bold;
        color: green; 
    }
    .total-container {
    border: 1px solid #ccc;
    padding: 10px;
}

.total-price table {
    width: 100%;
    border-collapse: collapse;
}

.total-price th, .total-price td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.total-price th {
    background-color: #f2f2f2;
}

.total-price td {
    background-color: #fff;
}

.total-price tr:nth-child(even) td {
    background-color: #f2f2f2;
}

  </style>
</head>
<body>
  <div class="main-container">
    <div class="container-1">
    <?php
   
    $conn = mysqli_connect('localhost', 'root', '', 'garmentmanagementsystem');

    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Initialize variables
    $totalPrice = 0; 
    $deliveryFee = 250.00; 

    // select items from the cart
    $sql = "SELECT item.itemId, 
                    item.itemName,
                    item.itemPhoto,
                    item.category,
                    item.material,
                    SUM(cart.quantity) AS cart_quantity,
                    SUM(cart.quantity * item.price) AS total_price
            FROM item 
            INNER JOIN cart ON item.itemId = cart.itemId
            GROUP BY item.itemId, 
                    item.itemName, 
                    item.itemPhoto, 
                    item.category, 
                    item.material";

    
    $result = mysqli_query($conn, $sql);

    
    if (mysqli_num_rows($result) > 0) {
        
        
        while ($row = mysqli_fetch_assoc($result)) {
            
           
            echo '<div class="cart-card">';
            echo '<div class="cart-item">';
            echo '<div class="image-container">'; 
            
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row["itemPhoto"]) . '" alt="' . $row["itemName"] . '" class="item-image">';
            echo '</div>'; 
            echo '<div class="details-container">'; 
            echo '<h3 class="item-name">' . $row["itemName"] . '</h3>';
            echo '<p class="item-quantity">Quantity: ' . $row["cart_quantity"] . '</p>';
            echo '<p class="item-price">Price: Rs.' . $row["total_price"] . '</p>';
            echo '</div>'; 
            echo '</div>'; 
            echo '</div>'; 

            // Update the quantity
            $sql_update_quantity = "UPDATE item 
                                    SET quantity = quantity - ? 
                                    WHERE itemId = ?";

            
            $stmt = mysqli_prepare($conn, $sql_update_quantity);

           
            mysqli_stmt_bind_param($stmt, "ii", $row["cart_quantity"], $row["itemId"]);

           
            mysqli_stmt_execute($stmt);

           
            mysqli_stmt_close($stmt);

            // Calculate total price
            $totalPrice += $row["total_price"];
        }

        $sql = "DELETE FROM cart WHERE userId=1";
        if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        } else {
        echo "Error deleting record: " . $conn->error;
        }

        // Calculate total payment
        $totalPayment = $totalPrice + $deliveryFee;

       
        echo '<div class="total-price">';
        echo '<table>';
        echo '<tr><th>Item</th><th>Price</th></tr>';
        echo '<tr><td>Total Price</td><td>Rs. ' . $totalPrice . '</td></tr>';
        echo '<tr><td>Delivery Fee</td><td>Rs. ' . $deliveryFee . '</td></tr>';
        echo '<tr><td>Total Payment</td><td>Rs. ' . $totalPayment . '</td></tr>';
        echo '</table>';
        echo '</div>';
        
    } else {
       
        echo "<p>No items in the cart.</p>";
    }

    
    mysqli_close($conn);
?>

    </div>
    <div class="container mt-5">
      <h2>STAY WITH US! Happy shopping!!!</h2>
      <form id="checkoutForm" action="home.php" method="post">
        <div class="form-group">
          <label for="fullName">Full Name:</label>
          <input type="text" class="form-control" id="fullName" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
          <label for="address">Address:</label>
          <textarea class="form-control" id="address" required></textarea>
        </div>
        <div class="form-group">
          <label for="cardNumber">Credit Card Number:</label>
          <input type="text" class="form-control" id="cardNumber" required>
        </div>
        <div class="form-group">
          <label for="expiryDate">Expiry Date:</label>
          <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
        </div>
        <div class="form-group">
          <label for="cvv">CVV:</label>
          <input type="text" class="form-control" id="cvv" required>
        </div>
        <button type="submit" class="btn btn-primary" id="userId">Place Order</button>
      </form>
    </div>
  </div>

 
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
  document.getElementById('checkoutForm').addEventListener('submit', function(event) {
      var fullName = document.getElementById('fullName').value;
      var email = document.getElementById('email').value;
      var address = document.getElementById('address').value;
      var cardNumber = document.getElementById('cardNumber').value;
      var expiryDate = document.getElementById('expiryDate').value;
      var cvv = document.getElementById('cvv').value;

      if (fullName.trim() === '' || email.trim() === '' || address.trim() === '' || cardNumber.trim() === '' || expiryDate.trim() === '' || cvv.trim() === '') {
          alert('Please fill in all fields.');
          event.preventDefault();
      } else if (!validateEmail(email)) {
          alert('Please enter a valid email address.');
          event.preventDefault();
      } else if (!validateCardNumber(cardNumber)) {
          alert('Please enter a valid credit card number (12 digits).');
          event.preventDefault();
      } else if (!validateExpiryDate(expiryDate)) {
          alert('Please enter a valid expiry date (MM/YY format).');
          event.preventDefault();
      } else if (!validateCVV(cvv)) {
          alert('Please enter a valid CVV.');
          event.preventDefault();
      } else {
          // Proceed with the order and remove items from the cart
          removeItemsFromCart();
          alert('Thank you for your payment! Stay in touch with us...');
      }
  });

  function removeItemsFromCart() {
      // Make an AJAX request to a PHP script to remove items from the cart
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "remove_items_from_cart.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              // Successfully removed items from the cart
          }
      };
      xhr.send();
  }

  function validateEmail(email) {
      var re = /\S+@\S+\.\S+/;
      return re.test(email);
  }

  function validateCardNumber(cardNumber) {
      return /^\d{12}$/.test(cardNumber);
  }

  function validateExpiryDate(expiryDate) {
      return /^\d{2}\/\d{2}$/.test(expiryDate);
  }

  function validateCVV(cvv) {
      return /^\d{3}$/.test(cvv);
  }
</script>



</body>
</html>

