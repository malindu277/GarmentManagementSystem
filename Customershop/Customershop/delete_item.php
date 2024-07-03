<?php


$conn = mysqli_connect('localhost', 'root', '', 'garmentmanagementsystem');


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    
    $sql = "DELETE FROM shopping_cart WHERE item_id = $itemId";
    if (mysqli_query($conn, $sql)) {
       
        http_response_code(204); 
    } else {
        
        http_response_code(500); 
    }
} else {
    
    http_response_code(400); 
}


mysqli_close($conn);
?>