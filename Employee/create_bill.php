<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $shopId = $_POST["shopId"];

    
    $sql = "INSERT INTO bill (shopId, create_date) VALUES ($shopId, NOW())"; 
    $result = mysqli_query($conn, $sql);

    
    $billId = mysqli_insert_id($conn);

   
    foreach ($_POST["items"] as $item) {
        $itemId = $item["itemId"];
        $quantity = $item["quantity"];
        $sql2 = "INSERT INTO bill_details (bill_id, itemId, quantity) VALUES ($billId, $itemId, $quantity)";
        $result = mysqli_query($conn, $sql2);
    }

    
    echo json_encode(["success" => true, "billId" => $billId]);
    exit; 
}
?>
