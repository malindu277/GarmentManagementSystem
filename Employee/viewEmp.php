<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="viewEmp.css">
</head>

<body class="bg-image">

    <header class="bg-primary py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50"
                        class="img-fluid rounded-circle">
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
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Employee Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <?php
                                include 'config.php';

                                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                    $name = $_GET['id'];
                                }

                                $sql = "SELECT * FROM `employee` WHERE username = ?";
                                $stmt = $conn->prepare($sql);

                                $tempName = "malindu";


                                $stmt->bind_param("s", $name);
                                $stmt->execute();


                                $result = $stmt->get_result();


                                if ($result->num_rows > 0) {

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['profile_photo_content']) . '" alt="Employee Photo" class="img-fluid rounded-circle mb-3">';

                                        if (isset($_GET['empId']) && !empty($_GET['empId'])) {
                                            $empId = $_GET['empId'];
                                            echo "<p><strong>Employee ID:</strong> $empId</p>";
                                        } else {
                                            echo "<p><strong>Employee ID:</strong> Not Available</p>";
                                        }
                                    }
                                } else {
                                    echo '<img src="default_photo.jpg" alt="Default Photo" class="img-fluid rounded-circle mb-3">';
                                    echo "<p><strong>Employee ID:</strong> Not Available</p>";
                                }


                                
                                // Fetch salary details for this employee
                                $sql_salary = "SELECT * FROM salary WHERE empId = ? ORDER BY Month";
                                $stmt_salary = $conn->prepare($sql_salary);
                                $stmt_salary->bind_param("s", $employeeId);
                                $stmt_salary->execute();
                                $result_salary = $stmt_salary->get_result();

                                // Display salary details in a table
                                if ($result_salary->num_rows > 0) {
                                    echo "<h4>Salary Details</h4>";
                                    echo "<table class='table'>";
                                    echo "<thead><tr><th>Month</th><th>Total Salary</th></tr></thead>";
                                    echo "<tbody>";
                                    while ($row_salary = $result_salary->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row_salary['Month'] . "</td>";
                                        echo "<td>" . $row_salary['TotSalary'] . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                }



                                ?>
                            </div>


                            <div class="col-md-8">
                                <?php


                                $sql = "SELECT * FROM `employee` WHERE username = ?";
                                $stmt = $conn->prepare($sql);


                                $stmt->bind_param("s", $name);
                                $stmt->execute();


                                $result = $stmt->get_result();


                                if ($result->num_rows > 0) {

                                    while ($row = $result->fetch_assoc()) {
                                        echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                                        echo '<p class="card-text"><strong>Age:' . $row['age'] . '</strong> </p>';
                                        echo '<p class="card-text"><strong>Date of Birth:' . $row['DOB'] . '</strong> </p>';
                                        echo '<p class= "card-text"><strong>NIC: ' . $row['NIC'] . '</strong> </p>';
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




                            <div class="mt-3 btn-container">
                                <button class="btn btn-primary"
                                    onclick="window.location.href='empPro.php'">Back</button>
                                <button class="btn btn-success btn-center"
                                    onclick="window.location.href='updateEmp.php?empId=<?php echo $empId; ?>'">Update</button>

                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="salary-details-container">



        <div class="container d-flex justify-content-center align-items-center" style="min-height: 30vh">
            <div class="card" style="width: 40rem;">
                <div class="card-body">
                    <h5 class="card-title h4">Salary Details</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                    <p class="card-text">
                        <?php
                        // Fetch salary details for this employee
                        $sql_salary = "SELECT * FROM salary WHERE empId = ?";
                        $stmt_salary = $conn->prepare($sql_salary);
                        $stmt_salary->bind_param("s", $empId);
                        $stmt_salary->execute();
                        $result_salary = $stmt_salary->get_result();

                        // Display salary details in a table
                        if ($result_salary->num_rows > 0) {
                            // echo "<h4>Salary Details</h4>";
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
                        $conn->close();
                        ?>
                    </p>
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