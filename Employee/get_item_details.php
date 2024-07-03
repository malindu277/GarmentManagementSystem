<?php

include_once 'config.php';

// Get the item ID from the AJAX request
$itemId = $_POST['itemId'];

// Prepare a SQL query to fetch the item details based on the item ID
$sql = "SELECT itemName, price FROM item WHERE itemId = ?";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $itemId);
$stmt->execute();

// Bind the result variables
$stmt->bind_result($itemName, $price);

// Fetch the result
$stmt->fetch();

// Close the statement
$stmt->close();

// Return the item details as JSON
echo json_encode(array('itemName' => $itemName, 'price' => $price));


$conn->close();
?>