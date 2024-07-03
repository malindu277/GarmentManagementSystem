<?php
session_start();
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empId = $_POST['empId'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $DOB = $_POST['DOB'];
    $NIC= $_POST['NIC'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];

    
    $sql = "UPDATE employee SET name=?, age=?, DOB=?, NIC=?, address=?, email=?, contact_no=? WHERE empId=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
    }

    if (!$stmt->bind_param("sisssssi", $name, $age, $DOB, $NIC, $address, $email, $contact_no, $empId)) {
        echo "Error binding parameters: " . $stmt->error;
    }

    if ($stmt->execute()) {
        header("Location: empPro.php");
        exit();
    } else {
        echo "Error updating employee details: " . $stmt->error;
    }

    $stmt->close();
}

// Check if employee ID is provided via GET method
if(isset($_GET['empId'])) {
    $empId = $_GET['empId'];
    
    // Fetch employee details from the database based on the provided employee ID
    $sql = "SELECT * FROM employee WHERE empId=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if employee exists
    if($result->num_rows == 1) {
        // Fetch employee details
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $age = $row['age'];
        $DOB = $row['DOB'];
        $NIC = $row['NIC'];
        $address = $row['address'];
        $email = $row['email'];
        $contact_no = $row['contact_no'];
    } else {
        // Handle case when employee does not exist
        echo "Employee not found.";
        exit();
    }
} else {
    // Handle case when employee ID is not provided
    echo "Employee ID not provided.";
    exit();
}

// Close prepared statement
$stmt->close();

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="regEmp.css">
    <style>
        header {
            position: relative;
            background-size: cover;
            color: #fff;
            padding: 20px 0;
            animation: fadeIn 1s ease forwards;
        }

        
        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            backdrop-filter: blur(10px); 
        }

        header h1 {
            margin-bottom: 5px;
            font-weight: 700;
            font-size: 32px;
        }

        header p {
            margin-bottom: 0;
            font-weight: 400;
        }

        
        header img {
            width: 120px;
            border-radius: 50%;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #343a40; 
            color: white;
            text-align: center;
            padding: 15px;
        }

        
        footer p {
            margin-bottom: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<header class="bg-primary py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle">
            </div>
            <div class="col-md-8 text-center text-md-left">
                <h1 class="text-white mb-0">Dil Fashion</h1>
                <p class="lead text-white mb-0">Your Fashion Destination</p>
            </div>
            <div class="col-md-2 text-right">
                <form method="POST" action="Adminlogin.php">
                    <input type="hidden" name="logout" value="true"> <!-- Add a hidden input field to indicate logout -->
                    <button type="submit" class="btn btn-dark logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h2 class="text-primary text-center mb-4">Update Employee Details</h2>
                        
                        <form action="updateEmp.php" method="post">
                            <div class="form-group">
                                <label for="empId"><i class="fas fa-id-card"></i> Employee ID:</label>
                                <input type="text" class="form-control" id="empId" name="empId" value="<?php echo $empId; ?>" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="age"><i class="fas fa-birthday-cake"></i> Age:</label>
                                    <input type="number" class="form-control" id="age" name="age" value="<?php echo $age; ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="DOB"><i class="fas fa-calendar-alt"></i> Date of Birth:</label>
                                    <input type="date" class="form-control" id="DOB" name="DOB" value="<?php echo $DOB; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="fas fa-map-marker-alt"></i> Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contact_no"><i class="fas fa-phone"></i> Contact Number:</label>
                                <input type="tel" class="form-control" id="contact_no" name="contact_no" value="<?php echo $contact_no; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Update</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <footer class="bg-dark text-white text-center py-3 mt-5 footer">
        <div class="container">
            <p>© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>
    

   
    
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Employee updated successfully!
                </div>
            </div>
        </div>
    </div>s

    
    <script>
        const response = <?php echo json_encode($_GET); ?>;
        if (response.success) {
            $('#successModal').modal('show');
        }

        document.getElementById('contact_no').addEventListener('input', function(event) {
            const input = event.target;
            input.value = input.value.replace(/\D/g, ''); 
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10); 
            }
        });
    </script>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>





