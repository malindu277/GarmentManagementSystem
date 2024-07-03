<?php
include 'config.php'; 

$shopId = $_POST['shopId'];

// Perform a query to fetch the shop name based on the shop ID
$query = "SELECT name FROM shop WHERE shopId = $shopId";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['name']; // shop name
} else {
    echo "Error fetching shop name";
}

mysqli_close($conn);
?>