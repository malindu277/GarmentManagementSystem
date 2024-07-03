<?php

$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "garmentmanagementsystem"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}


$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (empty($_POST['itemName']) || empty($_POST['material']) || empty($_POST['quantity']) || empty($_POST['price']) || empty($_POST['category'])) {
        $error = "All fields are required";
    } else {
        
        $itemName = $_POST['itemName'];
        $material = $_POST['material'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['category']; 

        
        if(isset($_FILES['itemPhoto']) && $_FILES['itemPhoto']['error'] === UPLOAD_ERR_OK) {
            
            $fileTmpPath = $_FILES['itemPhoto']['tmp_name'];
            $fileName = $_FILES['itemPhoto']['name'];
            $fileSize = $_FILES['itemPhoto']['size'];
            $fileType = $_FILES['itemPhoto']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

           
            $allowedExtensions = array('jpg', 'jpeg', 'png');
            if (in_array($fileExtension, $allowedExtensions)) {
                
                $itemPhoto = addslashes(file_get_contents($fileTmpPath));
    
                $sql = "INSERT INTO item (itemName, material, quantity, price, itemPhoto, category) VALUES ('$itemName', '$material', '$quantity', '$price', '$itemPhoto', '$category')";

                
                if ($conn->query($sql) === TRUE) {
                
                    header("Location: detailpage.php");
                    exit; 
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $error = "Only JPG, JPEG, and PNG files are allowed";
            }
        } else {
            $error = "Please select a file";
        }
    }
}

$conn->close();
?>

