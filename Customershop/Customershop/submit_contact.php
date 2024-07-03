<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garmentmanagementsystem";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$message = $conn->real_escape_string($_POST['message']);


$sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    
    echo "<script>
            var newWindow = window.open('', '_blank', 'width=400,height=200');
            newWindow.document.body.innerHTML = '<div style=\"font-family: Arial, sans-serif; text-align: center; margin-top: 50px;\"><h2 style=\"color: green;\">Thank You For Contacting Us.</h2><p style=\"color: green;\">We will get back to you shortly...</p></div>';
            setTimeout(function() {
                newWindow.close();
                window.location.href = 'contact.php';
            }, 3000); 
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>
