<?php
// Establish connection to MySQL database
$servername = "localhost"; 
$username = "root";
$password = ""; // MySQL password
$dbname = "garmentmanagementsystem"; // database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Failed to connect to MySQL: " . $conn->connect_error);
}

// Initialize error variable
$error = "";

// Check if the form is submitted

        $sql = "INSERT INTO `item` (`itemName`, `itemPhoto`, `material`, `quantity`, `price`) VALUES ( 'frock', NULL, 'silk', '200', '2500')";

        // Execute query
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    


// Close connection
$conn->close();
?>

