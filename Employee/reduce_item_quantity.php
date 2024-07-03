<?php
// Include the database connection file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the item ID and quantity from the request
    $itemId = $_POST["itemId"];
    $quantity = $_POST["quantity"];

    // Update the item quantity in the database
    $sql = "UPDATE item SET quantity = quantity - $quantity WHERE itemId = $itemId";
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        
        echo json_encode(["success" => true, "message" => "Item quantity reduced successfully"]);
    } else {
        // Send an error response
        echo json_encode(["success" => false, "message" => "Failed to reduce item quantity"]);
    }

    exit; // Ensure script execution stops after sending JSON response
}
?>