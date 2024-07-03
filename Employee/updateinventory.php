<?php
include 'config.php';


if(isset($_GET['itemId']) && !empty($_GET['itemId'])) {
    $itemId = $_GET['itemId'];

} else {
    echo "Debug: Item ID not received from GET. <br>";
}

if(isset($itemId)) {
    $sql = "SELECT * FROM item WHERE itemId = $itemId";
    $result = $conn->query($sql);

    if($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
       
        $itemName = $row['itemName'];
        $material = $row['material'];
        $category = $row['category'];
        $quantity = $row['quantity'];
        $price = $row['price'];
    } else {
        echo "Item not found.";
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Debug: Form submitted. <br>";
    $itemId = $_POST['itemId'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    echo "Debug: Item ID received from form: " . $itemId . "<br>";

   
    $sql = "UPDATE item SET quantity = '$quantity', price = '$price' WHERE itemId = '$itemId'";
    if ($conn->query($sql) === TRUE) {
        
        header("Location: viewdetail.php?itemId=$itemId");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
     
        .custom-header {
            background-color: #000080; 
        }
       
        .custom-header h1 {
            margin-bottom: 0; 
        }
       
        .logout-btn {
            margin-right: 0;
        }
   
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #343a40; 
            color: white;
            text-align: center;
            padding: 15px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header class="custom-header py-4">
        <div class="container">
            <div class="row align-items-center justify-content-center"> 
                <div class="col-md-2 text-center">
                    <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle ">
                </div>
                <div class="col-md-8 text-center">
                    <h1 class="text-white mb-0">Dil Fashion</h1>
                    <p class="lead text-white mb-0">Your Fashion Destination</p>
                </div>
            </div>
        </div>
    </header>
    <!--Header -->

    <div class="container">
        <h1 class="text-center mb-4">Update Inventory</h1>
        <form action="updateinventory.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="itemPhoto"><i class="fas fa-camera"></i> Item Photo</label>
                <input type="file" class="form-control-file" id="itemPhoto" name="itemPhoto">
            </div>
            
            <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
            <div class="form-group">
                <label for="itemName"><i class="fas fa-tag"></i> Item Name</label>
                <input type="text" class="form-control" id="itemName" name="itemName" value="<?php echo $itemName; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="category"><i class="fas fa-tag"></i> Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo $category; ?>" readonly> <!-- Display category -->
            </div>
            <div class="form-group">
                <label for="material"><i class="fas fa-scroll"></i> Material</label>
                <input type="text" class="form-control" id="material" name="material" value="<?php echo $material; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="quantity"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
              
            </div>
            <div class="form-group">
                <label for="price"><i class="fas fa-coins"></i> Price (Rupees)</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary done-button">Update</button>
           
            <button type="button" class="btn btn-primary back-button" onclick="redirectToDetailPage()">Back</button>
        </form>
    </div>

   
    <footer class="bg-dark text-white text-center py-3 mt-5 footer">
        <div class="container">
            <p>© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function redirectToDetailPage() {
            window.location.href = "viewdetail.php?itemId=<?php echo $itemId; ?>";
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>
