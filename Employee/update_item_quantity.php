<?php
require_once('config.php');

// Retrieve item ID and quantity from the POST request
$itemId = $_POST['itemId'];
$quantity = $_POST['quantity'];

// Update the item quantity in the database
$query = "UPDATE item SET quantity = quantity - $quantity WHERE itemId = $itemId";

if (mysqli_query($conn, $query)) {
    echo "Item quantity updated successfully";
} else {
    echo "Error updating item quantity: " . mysqli_error($conn);
}

mysqli_close($conn);
?>