<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $itemId = $_POST["itemId"];
    $quantity = $_POST["quantity"];

 
    $query = "SELECT quantity FROM item WHERE itemId = $itemId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $availableQuantity = $row["quantity"];

        
        if ($quantity <= $availableQuantity) {
           
            echo json_encode(["valid" => true]);
        } else {
            echo json_encode(["valid" => false]);
        }
    } else {
        
        echo json_encode(["valid" => false, "error" => "Failed to fetch item quantity"]);
    }
}
?>