<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop page</title>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>

        body {
            background-image: url('img/2655.jpg');
          
        }

        .card-img-top {
            height: 200px; 
            object-fit: cover; 
        }

        .card {
            height: 100%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #quantity {
            width: 60px;
        }

        .form-group {
            display: flex;
            align-items: center;
        }

        #page-header {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <section id="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a href="#"><img src="img/logo.png" alt="" height="75px" class="round-img"></a>
                </div>
                <div class="col-md-10">
                    <ul class="nav justify-content-end">
                        <li class="nav-item"><a class="nav-link text-dark" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active text-dark" href="shop.php">Shop</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="blog.php">Blog</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="cart.php"><i class="fas fa-cart-shopping"></i></a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="index.php"><i class="fas fa-user"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <section id="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>#ShopWithUs</h2>
                    <p>Save more with coupons upto 70% off!</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
        <?php
            $conn = mysqli_connect('localhost', 'root', '', 'garmentmanagementsystem');

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id']) && !empty($_POST['item_id'])) {
                $itemId = $_POST['item_id'];
                $itemName = $_POST['item_name']; 
                $quantity = $_POST['quantity']; 
            
                $sql = "INSERT INTO cart (itemId, itemName, quantity,userId) VALUES ('$itemId', '$itemName', '$quantity', 1)";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Item added to cart successfully');</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            
            
            $sql = "SELECT itemId, itemName, itemPhoto, category, material, quantity, price FROM item";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card" style="width: 18rem;">';
                    
                    $imageData = base64_encode($row["itemPhoto"]);
                    
                    echo '<img class="card-img-top" src="data:image/jpeg;base64,' . $imageData . '" alt="' . $row["itemName"] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["itemName"] . '</h5>';
                    echo '<p class="card-text">Material: ' . $row["material"] . '</p>';
                    echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">'; 
                    echo '<div class="form-group">'; 
                    echo '<label for="quantity">Quantity:</label>';
                    echo '<input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>';
                    echo '</div>'; 
                    echo '<p class="card-text">Price: LKR' . $row["price"] . '</p>';
                    
                    echo '<input type="hidden" name="item_id" value="' . $row["itemId"] . '">';
                    echo '<input type="hidden" name="item_name" value="' . $row["itemName"] . '">'; 
                    echo '<button type="submit" class="btn btn-primary">Add to Cart</button>';
                    echo '</form>'; 
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No items found.";
            }

            mysqli_close($conn);
        ?>

        </div>
    </div>
     <br><br><br><br>
    <footer class="section-p1">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img class="logo" src="img/logo.png" height="75px" alt="">
                    <h4>Contact</h4>
                    <p><strong>Address : 293/10,Dikwela Road,Siyambalape</strong></p>
                    <p><strong>Phone : 0714411044</strong></p>
                    <p><strong>Working Hours : 8AM - 5PM</strong></p>
                    <div class="follow">
                        <h4>Follow Us</h4>
                        <div class="icon">
                            <i class="fab fa-facebook-f"></i>
                            <i class="fab fa-instagram"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <h4>About</h4>
                    <a href="#">About Us</a>
                    <a href="#">Delivery Information</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Contact Us</a>
                </div>

                <div class="col-md-3">
                    <h4>My Account</h4>
                    <a href="#">Sign In</a>
                    <a href="#">View cart</a>
                    <a href="#">My Wishlist</a>
                    <a href="#">Track My Order</a>
                    <a href="#">Help</a>
                </div>

                <div class="col-md-3 install">
                    <p>Secured Payment Gateways</p>
                    <img src="img/pay/pay.png" alt="">
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>2024, DilFashion etc</p>
                </div>
            </div>
        </div>
    </footer>

    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>

   
    <script>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
            
            var addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
            addToCartButtons.forEach(function(button) {
                button.addEventListener("click", function(event) {
                    var itemId = button.dataset.itemId; 
                    addToCart(itemId); 
                });
            });

            
            function addToCart(itemId) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "add_to_cart.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                           
                            console.log(xhr.responseText);
                        } else {
                           
                            console.error("Error adding item to cart");
                        }
                    }
                };
                xhr.send("item_id=" + encodeURIComponent(itemId));
            }
            });
        </script>
    </script>
</body>

</html>