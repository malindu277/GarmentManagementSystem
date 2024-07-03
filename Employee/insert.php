<?php
include_once 'config.php';

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $DOB = $_POST['DOB'];
    $NIC= $_POST['NIC'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password']; 

   

    
    $fileName = $_FILES['profile_photo']['name'];
    $fileTmpName = $_FILES['profile_photo']['tmp_name'];
    $fileSize = $_FILES['profile_photo']['size'];
    $fileType = $_FILES['profile_photo']['type'];

    $fileContent = file_get_contents($fileTmpName);

    
    $sql = "INSERT INTO employee (name, age, DOB, NIC, address, email, contact_no, username, password, profile_photo_name, profile_photo_type, profile_photo_size, profile_photo_content) VALUES (?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>alert('Error preparing statement: ".$conn->error."');</script>";
    }

    if (!$stmt->bind_param("sisssssssssss", $name, $age, $DOB,$NIC, $address, $email, $contact_no, $username, $password, $fileName, $fileType, $fileSize, $fileContent)) {
        echo "<script>alert('Error binding parameters: ".$stmt->error."');</script>";
    }

    if ($stmt->execute()) {
        echo "<script>alert('Employee details inserted successfully!');</script>";
        $last_id = $conn->insert_id;
       
        $encoded_username = urlencode($username);
        header("Location: empPro.php?id=$encoded_username&empId=$last_id");
        exit(); 
    } else {
        echo "<script>alert('Error inserting employee details: ".$stmt->error."');</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Form not submitted.');</script>";
}


$conn->close();
?>

