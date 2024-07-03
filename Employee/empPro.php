<?php

include_once 'config.php';

if(isset($_POST['logout'])) {
   
    $_SESSION = array();

   
    session_destroy();

   
    header("Location: Adminlogin.php");
    exit;
}


$sql = "SELECT * FROM employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
       
        .custom-header {
            background-color: #000080; 
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        footer {
            background-color: #343a40; 
            color: white;
            text-align: center;
            padding: 15px;
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        @media (max-width: 768px) {
            .logout-btn {
                position: static;
                margin-top: 10px;
            }
        }

    </style>
</head>
<body>
    
    <header class="custom-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle ">
                </div>
                <div class="col-md-8 text-center text-md-left">
                    <h1 class="text-white mb-0">Dil Fashion</h1>
                    <p class="lead text-white mb-0">Your Fashion Destination</p>
                </div>
                <div class="col-md-2 text-right">
                    <form method="POST" action=""> 
                        <button type="submit" class="btn btn-dark logout-btn" name="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    


    <main class="container mt-5">
    
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="" class="form-inline">
                <div class="form-group mr-2">
                    <label for="employee_name" class="sr-only">Employee Name</label>
                    <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Enter Employee Name">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="row">
        <?php
        
        if ($result->num_rows > 0) {
            
            if (isset($_GET['employee_name'])) {
                $search_name = $_GET['employee_name'];
                $sql = "SELECT * FROM employee WHERE name LIKE '%$search_name%'";
                $search_result = $conn->query($sql);

               
                if ($search_result->num_rows > 0) {
                    while ($row = $search_result->fetch_assoc()) {
                       
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="data:image/jpeg;base64,<?= base64_encode($row['profile_photo_content']) ?>" class="card-img-top" alt="Employee Photo">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['name'] ?></h5>
                    <p class="card-text">Employee ID: <?= $row['empId'] ?></p>
                    <a href="viewEmp.php?id=<?= urlencode($row['username']) ?>&empId=<?= $row['empId'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php
                    }
                } else {
                    
                    echo "<p>No employee found with the provided name.</p>";
                }
            } else {
               
                while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="data:image/jpeg;base64,<?= base64_encode($row['profile_photo_content']) ?>" class="card-img-top" alt="Employee Photo">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['name'] ?></h5>
                    <p class="card-text">Employee ID: <?= $row['empId'] ?></p>
                    <a href="viewEmp.php?id=<?= urlencode($row['username']) ?>&empId=<?= $row['empId'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php
                }
            }
        } else {
            echo "<p>No employees found.</p>";
        }
        ?>
    </div>
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <a href="EmpDash.html" class="btn btn-dark btn-block">Back</a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="regEmp.html" class="btn btn-success btn-block">Register Employee</a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="deleteEmp.php" class="btn btn-danger btn-block">Delete Employee</a>
        </div>
    </div>

</div>

</main>


</main>


   
    <footer>
        <div class="container">
            <p>© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>
   

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

$conn->close();
?>
