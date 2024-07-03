<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="viewEmp.css">
</head>
<body class="bg-image">
   
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
                <form method="POST" action="empLogin.php">
                    <input type="hidden" name="logout" value="true"> 
                    <button type="submit" class="btn btn-dark logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Employee Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <?php 
                                include 'config.php';

                                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['empId'])) {
                                    $empId = $_GET['empId'];
                                }

                                $sql = "SELECT * FROM `employee` WHERE empId = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $empId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['profile_photo_content']).'" alt="Employee Photo" class="img-fluid rounded-circle mb-3">';
                                        echo "<p><strong>Employee ID:</strong> $empId</p>"; 
                                    }
                                } else {
                                    echo '<img src="employee_photo.jpg" alt="Employee Photo" class="img-fluid mb-3" style="width: 200px; height: 200px;">';
                                    echo "<p><strong>Employee ID:</strong> $empId</p>";
                                }
                                
                                ?> 
                            </div>

                           
                            <div class="col-md-8">
                                <?php 
                                include 'config.php';

                                $sql = "SELECT * FROM `employee` WHERE empId = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $empId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                                        echo '<p class="card-text"><strong>Age:' . $row['age'] . '</strong> </p>';
                                        echo '<p class="card-text"><strong>Date of Birth:' . $row['DOB'] . '</strong> </p>';
                                        echo '<p class= "card-text"><strong>NIC: ' .$row['NIC'] . '</strong> </p>';
                                        echo '<p class="card-text"><strong>Address:' . $row['address'] . '</strong> </p>';
                                        echo '<p class="card-text"><strong>Email:' . $row['email'] . '</strong> </p>';
                                        echo '<p class="card-text"><strong>Contact No:' . $row['contact_no'] . '</strong> </p>';
                                        echo '<p class="card-text"><strong>Username:' . $row['username'] . '</strong> </p>';
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No data found</td></tr>";
                                }
                               
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Details Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Salary Details
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch salary details for this employee
                        $sql_salary = "SELECT * FROM salary WHERE empId = ?";
                        $stmt_salary = $conn->prepare($sql_salary);
                        $stmt_salary->bind_param("s", $empId);
                        $stmt_salary->execute();
                        $result_salary = $stmt_salary->get_result();

                        // Display salary details in a table
                        if ($result_salary->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<thead><tr><th scope='col'>Month</th><th scope='col'>Total Salary</th></tr></thead>";
                            echo "<tbody>";
                            while ($row_salary = $result_salary->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_salary['Month'] . "</td>";
                                echo "<td>" . $row_salary['TotSalary'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>No salary details found.</p>";
                        }
                        ?>
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



    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
