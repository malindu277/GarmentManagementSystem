<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
       
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 300px;
            text-align: center;
        }
        .card-body p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Item Details</h5>
                <?php
               
                if(isset($_GET['itemId']) && !empty($_GET['itemId'])) {
                    $itemId = $_GET['itemId'];

                    
                    $sql = "SELECT * FROM item WHERE itemId = $itemId";
                    $result = $conn->query($sql);

                    if($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                ?>
                        <?php if (!empty($row['itemPhoto'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['itemPhoto']); ?>" class="card-img-top" alt="Item Photo">
                        <?php else: ?>
                            <div class="alert alert-danger">No photo available</div>
                        <?php endif; ?>
                        <div class="card-text">
                            <p>Item ID: <?php echo $row['itemId']; ?></p>
                            <p>Item Name: <?php echo $row['itemName']; ?></p>
                            <p>Category: <?php echo $row['category']; ?></p> 
                            <p>Material: <?php echo $row['material']; ?></p>
                            <p>Quantity: <?php echo $row['quantity']; ?></p>
                            <p>Price: <?php echo $row['price']; ?></p>
                            
                            <a href="updateinventory.php?itemId=<?php echo $itemId; ?>" class="btn btn-primary">Update</a>
                            <a href="detailpage.php" class="btn btn-primary back-button">Back</a>
                        </div>
                <?php
                    } else {
                        echo "<p>Item not found.</p>";
                    }
                } else {
                    echo "<p>Item ID not specified.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
