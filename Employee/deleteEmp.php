<?php
include_once 'config.php';

function deleteEmployee($conn, $empId) {
 
    $conn->begin_transaction();

    try {
        // Delete  records from salary 
        $sql_delete_salary = "DELETE FROM salary WHERE empId=?";
        $stmt_delete_salary = $conn->prepare($sql_delete_salary);
        $stmt_delete_salary->bind_param("i", $empId);
        $stmt_delete_salary->execute();
        
        //  delete employee record
        $sql_delete_employee = "DELETE FROM employee WHERE empId=?";
        $stmt_delete_employee = $conn->prepare($sql_delete_employee);
        $stmt_delete_employee->bind_param("i", $empId);
        $stmt_delete_employee->execute();
        
        
        $conn->commit();
        
        return true; 
    } catch (Exception $e) {
        
        $conn->rollback();
        return false; 
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emp_id']) && !empty($_POST['emp_id'])) {
    $empId = $_POST['emp_id'];
    
    
    if (deleteEmployee($conn, $empId)) {
       
        header("Location: deleteEmp.php?success=true");
        exit();
    } else {
        
        header("Location: deleteEmp.php?error=true");
        exit();
    }
}


$sql = "SELECT empId, name FROM employee";
$result = $conn->query($sql);
$employees = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
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

       
        .form-group label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            background-color: rgba(255, 255, 255, 0.9); 
            box-shadow: none;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            backdrop-filter: blur(5px); 
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: none;
        }

     
        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

        footer p {
            margin-bottom: 0;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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
                    <input type="hidden" name="logout" value="true"> 
                    <button type="submit" class="btn btn-dark logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

  

    <div class="container mt-5">
        <div class="row">
            
            <div class="col-md-4">
                <h4>Employee List</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?php echo $employee['empId']; ?></td>
                                <td><?php echo $employee['name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h2 class="text-danger text-center mb-4">Delete Employee</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="emp_id"><i class="fas fa-id-badge"></i> Employee ID:</label>
                                <input type="text" class="form-control" id="emp_id" name="emp_id" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block" onclick="confirmDelete()"><i class="fas fa-trash-alt"></i> Delete</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                <a href="empPro.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
            </div>
        </div>
    </div>

   
    <footer>
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
                    Employee deleted successfully!
                </div>
            </div>
        </div>
    </div>

  
    <script>
      
        const response = <?php echo json_encode($_GET); ?>;

       
        if (response.success) {
            
            $('#successModal').modal('show');
        }

        function confirmDelete() {
        if (confirm("Do you want to delete?")) {
            
            document.querySelector('form').submit();
        }
        
        }
    </script>

  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>








