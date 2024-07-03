<?php
include 'config.php';

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    $sql = "DELETE FROM bill_details WHERE itemId = $itemId";
    if (mysqli_query($conn, $sql)) {
        echo "Item deleted successfully!";
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>