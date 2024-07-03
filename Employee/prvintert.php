<?php
include_once 'config.php';

// Check if form is submitted and file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['photo'])) {
    // Check if file upload is successful
    if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['name']; // Access file name from $_FILES array
        $name = $_POST['name'];
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $contactNo = $_POST['contactNo'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO employee (photo, name, age, dob, address, email, contactNo, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissssss", $photo, $name, $age, $dob, $address, $email, $contactNo, $username, $password);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Move uploaded file to desired location
            move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);
            echo "Employee details inserted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "File upload failed with error code: " . $_FILES['photo']['error'];
    }
} else {
    echo "Form not submitted or file not uploaded.";
}

// Drop the trigger if it already exists
$dropTriggerSql = "DROP TRIGGER IF EXISTS before_insert_employee";

if ($conn->query($dropTriggerSql) === TRUE) {
    // Create the trigger
    $triggerSql = "CREATE TRIGGER before_insert_employee
                   BEFORE INSERT ON employee
                   FOR EACH ROW
                   BEGIN
                       DECLARE new_id VARCHAR(10);
                       SET new_id = CONCAT('DFE', LPAD((SELECT IFNULL(SUBSTRING(employee_id, 4), 0) + 1), 3, '0'));
                       SET NEW.employee_id = new_id;
                   END";

    if ($conn->query($triggerSql) === TRUE) {
        echo "Trigger created successfully";
    } else {
        echo "Error creating trigger: " . $conn->error;
    }
} else {
    echo "Error dropping trigger: " . $conn->error;
}

$conn->close();
?>




