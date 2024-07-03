<?php
include 'config.php';

if (isset($_POST['itemId']) && isset($_POST['quantity'])) {
    $itemId = $_POST['itemId'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE bill_details SET quantity = $quantity WHERE itemId = $itemId";
    if (mysqli_query($conn, $sql)) {
        echo "Item quantity updated successfully!";
    } else {
        echo "Error updating item quantity: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>