
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .custom-header {
            background-color: #000080;
        }
        body {
            background-image: url('img/2655.jpg');
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #343a40; 
            color: white;
            text-align: center;
            padding: 15px;
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        @media (max-width: 768px) {
            .logout-btn {
                position: static;
                margin-top: 10px;
            }
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; 
        }
        .item {
            position: relative; 
            width: 300px; 
            height: 400px; 
            overflow: hidden; 
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .item img {
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
        }
        .item-content {
            padding: 10px;
        }
        .item h3 {
            margin: 0;
        }
        .item p {
            margin: 5px 0;
        }
        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff0000;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            cursor: pointer;
        }
        


    </style>
</head>
<body>

    <header class="custom-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="img/Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle ">
                </div>
                <div class="col-md-8 text-center text-md-left">
                    <h1 class="text-white mb-0">Dil Fashion</h1>
                    <p class="lead text-white mb-0">Your Fashion Destination</p>
                </div>
                <div class="col-md-2 text-right">
                    <form method="POST" action="login.php"> 
                        <button type="submit" class="btn btn-dark logout-btn" name="logout">Logout</button>
                    </form>
                    
                </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-5">
        <?php

        $conn = mysqli_connect('localhost', 'root', '', 'garmentmanagementsystem');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        if (isset($_POST['delete_item'])) {
           
            $itemId = mysqli_real_escape_string($conn, $_POST['item_id']);
            
        
            $delete_query = "DELETE FROM cart WHERE itemId = '$itemId'";
            if(mysqli_query($conn, $delete_query)) {
                
                echo "<script>alert('Item deleted successfully.')</script>";
            } else {
                echo "<script>alert('Error deleting item: " . mysqli_error($conn) . "')</script>";
            }
        }

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
                echo '<div class="item">';
        
                $imageData = base64_encode($row["itemPhoto"]);
                
                echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="' . $row["itemName"] . '" class="item-image">';
                echo '<div class="item-content">';
                echo '<h3>' . $row["itemName"] . '</h3>';
                echo '<p>Material: ' . $row["material"] . '</p>';
                echo '<p>Quantity: ' . $row['cart_quantity'] . '</p>';
                echo '<p>Total Price: LKR' . $row["total_price"] . '</p>';
                
                echo '<form method="POST">';
                echo '<input type="hidden" name="item_id" value="' . $row["itemId"] . '">';
                echo '<button type="submit" name="delete_item" class="delete-button">&times;</button>';
                echo '</form>';
            
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No items in the cart.</p>";
        }

        
        mysqli_close($conn);
        ?>
    </main>
    

    <div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <a href="shop.php" class="btn btn-secondary btn-lg">Back to Shop</a>
        </div>
        <div class="col-md-6 text-md-right"> 
        <a href="checkout.php" class="btn btn-primary btn-lg">Checkout</a>

        </div>
    </div>
</div>




    <footer>
        <p>© 2024 Your Company Name. All rights reserved.</p>
    </footer>

</body>
</html>









