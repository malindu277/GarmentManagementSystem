<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        .custom-header {
            background-color: #000080;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        .employee-list {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            max-height: 300px; /* Adjust this height as needed */
            overflow-y: auto;
        }

        .employee-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .employee-list th, .employee-list td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .employee-list th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- Header with custom color -->
    <header class="custom-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="Screenshot 2024-03-29 103430.png" alt="Dil Fashion Logo" height="50" class="img-fluid rounded-circle">
                </div>
                <div class="col-md-10 text-center text-md-left">
                    <h1 class="text-white mb-0">Dil Fashion</h1>
                    <p class="lead text-white mb-0">Your Fashion Destination</p>
                </div>
            </div>
        </div>
    </header>

    <main class="container mt-5">
        <div class="row">
            <!-- Employee List -->
            <div class="col-md-4">
                <div class="employee-list">
                    <h3>Employee List</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Include configuration file
                                include 'config.php';

                                // Fetch employee information
                                $sql = "SELECT empId, name FROM employee";
                                $result = $conn->query($sql);

                                // Display employee list
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>". $row["empId"]. "</td>";
                                        echo "<td>". $row["name"]. "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>No employees found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Salary Calculator -->
            <div class="col-md-8">
                <h2>Salary Calculator</h2>
                <!-- Form for salary calculation -->
                <form action="" method="post" id="salaryForm">
                    <div class="form-group">
                        <label for="employeeId">Employee ID</label>
                        <!-- Dropdown for selecting employee ID -->
                        <select class="form-control" id="employeeId" name="employeeId" required>
                            <option value="">Select Employee ID</option>
                            <!-- PHP loop to populate employee IDs -->
                            <?php
                                if ($result->num_rows > 0) {
                                    $result->data_seek(0); // reset result set pointer
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='". $row["empId"]. "'>" . $row["empId"]. "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="employeeType">Employee Type</label>
                        <!-- Dropdown for selecting employee type -->
                        <select class="form-control" id="employeeType" name="employeeType" required onchange="updateBasicSalaryAndOT()">
                            <option value="">Select Type</option>
                            <option value="registered">Registered</option>
                            <option value="temporary">Temporary</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="basicSalary">Basic Salary</label>
                        <input type="number" class="form-control" id="basicSalary" name="basicSalary" readonly>
                    </div>
                    <div class="form-group">
                        <label for="month">Month</label>
                        <!-- Dropdown for selecting month -->
                        <select class="form-control" id="month" name="month" required>
                            <option value="">Select Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="otHours">OT Hours</label>
                        <input type="number" class="form-control" id="otHours" name="otHours" required>
                    </div>

                    <!-- Incentives -->
                    <div class="form-group">
                        <label>Incentives</label>
                        <div id="incentivesContainer"></div>
                        <button type="button" class="btn btn-info" onclick="addIncentive()">Add Incentive</button>
                    </div>

                    <!-- Deductions -->
                    <div class="form-group">
                        <label>Deductions</label>
                        <div id="deductionsContainer"></div>
                        <button type="button" class="btn btn-warning" onclick="addDeduction()">Add Deduction</button>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2" name="calculate">Calculate Salary</button>
                    <button type="button" class="btn btn-secondary" onclick="clearForm()">Clear</button>
                </form>

                <div class="mt-3">
                    <a href="EmpDash.html" class="btn btn-secondary">Back to Dashboard</a>
                </div>

                <?php
                    if(isset($_POST['calculate'])) {
                        // Retrieve form data
                        $employeeId = $_POST['employeeId'];
                        $employeeType = $_POST['employeeType'];
                        $month = $_POST['month'];
                        $otHours = $_POST['otHours'];
                        $basicSalary = $employeeType === "registered" ? 17500 : 17100;
                        $otRate = $employeeType === "registered" ? 131 : 120;
                        $otFee = $otHours * $otRate;
                        $epfEtf = $employeeType === "registered" ? 1500 : 0;

                        // Validate OT hours
                        if ($otHours < 0) {
                            echo "<script>alert('OT hours cannot be negative.')</script>";
                            exit;
                        }

                        // Check if salary record already exists for the given employee ID and month
                        $checkSalaryQuery = "SELECT * FROM salary WHERE empId = '$employeeId' AND month = '$month'";
                        $checkResult = $conn->query($checkSalaryQuery);
                        if ($checkResult->num_rows > 0) {
                            echo "<script>alert('Salary for this employee for the selected month has already been calculated.')</script>";
                            exit;
                        }

                        // Calculate incentives
                        $totalIncentives = 0;
                        if (isset($_POST['incentiveAmount'])) {
                            foreach ($_POST['incentiveAmount'] as $incentive) {
                                $totalIncentives += (float)$incentive;
                            }
                        }

                        // Calculate deductions
                        $totalDeductions = 0;
                        if (isset($_POST['deductionAmount'])) {
                            foreach ($_POST['deductionAmount'] as $deduction) {
                                $totalDeductions += (float)$deduction;
                            }
                        }

                        // Calculate total salary
                        $TotSalary = $basicSalary + $totalIncentives + $otFee - $totalDeductions - $epfEtf;

                        // Insert salary record into the database
                        $insertSalaryQuery = "INSERT INTO salary (empId, month, basicSalary, otHours, otFee, incentives, deductions, epfEtf, TotSalary) VALUES ('$employeeId', '$month', '$basicSalary', '$otHours', '$otFee', '$totalIncentives', '$totalDeductions', '$epfEtf', '$TotSalary')";
                        if ($conn->query($insertSalaryQuery) === TRUE) {
                            echo "Salary details saved successfully.";
                        } else {
                            echo "Error: " . $insertSalaryQuery . "<br>" . $conn->error;
                        }

                        // Query to fetch employee name based on employee ID
                        $getNameQuery = "SELECT name FROM employee WHERE empId = $employeeId";
                        $nameResult = $conn->query($getNameQuery);

                        if ($nameResult->num_rows > 0) {
                            // Fetch employee name
                            $row = $nameResult->fetch_assoc();
                            $employeeName = $row["name"];

                            // Display salary details
                            echo "<div id='salaryDetails' class='mt-3'>";
                            echo "<h4>Salary Details</h4>";
                            echo "<p>Employee Name: $employeeName</p>"; // Displaying employee name
                            echo "<p>Month: $month</p>";
                            echo "<p>OT Fee: Rs." . number_format($otFee) . "</p>";
                            echo "<p>Total Incentives: Rs." . number_format($totalIncentives) . "</p>";
                            echo "<p>Total Deductions: Rs." . number_format($totalDeductions) . "</p>";
                            echo "<p>EPF/ETF: Rs." . number_format($epfEtf) . "</p>";
                            echo "<h5>Total Salary: Rs." . number_format($TotSalary) . "</h5>";
                            echo "</div>";
                        } else {
                            echo "Employee not found";
                        }
                    }

                    // Close database connection
                    $conn->close();
                ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 Dil Fashion. All rights reserved.</p>
    </footer>

    <script>
        // JavaScript function to update basic salary and OT fee based on employee type
        function updateBasicSalaryAndOT() {
            var employeeType = document.getElementById("employeeType").value;
            var basicSalaryField = document.getElementById("basicSalary");
            var otRateField = document.getElementById("otRate");

            if (employeeType === "registered") {
                basicSalaryField.value = "17500";
            } else if (employeeType === "temporary") {
                basicSalaryField.value = "17100";
            } else {
                basicSalaryField.value = "";
            }
        }

        // JavaScript function to add an incentive input field dynamically
        function addIncentive() {
            var container = document.getElementById("incentivesContainer");
            var div = document.createElement("div");
            div.classList.add("input-group", "mb-2");

            var input = document.createElement("input");
            input.type = "number";
            input.name = "incentiveAmount[]";
            input.classList.add("form-control");
            input.placeholder = "Incentive Amount";

            var removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("btn", "btn-danger");
            removeButton.textContent = "Remove";
            removeButton.onclick = function() {
                container.removeChild(div);
            };

            var divButton = document.createElement("div");
            divButton.classList.add("input-group-append");
            divButton.appendChild(removeButton);

            div.appendChild(input);
            div.appendChild(divButton);
            container.appendChild(div);
        }

        // JavaScript function to add a deduction input field dynamically
        function addDeduction() {
            var container = document.getElementById("deductionsContainer");
            var div = document.createElement("div");
            div.classList.add("input-group", "mb-2");

            var input = document.createElement("input");
            input.type = "number";
            input.name = "deductionAmount[]";
            input.classList.add("form-control");
            input.placeholder = "Deduction Amount";

            var removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("btn", "btn-danger");
            removeButton.textContent = "Remove";
            removeButton.onclick = function() {
                container.removeChild(div);
            };

            var divButton = document.createElement("div");
            divButton.classList.add("input-group-append");
            divButton.appendChild(removeButton);

            div.appendChild(input);
            div.appendChild(divButton);
            container.appendChild(div);
        }

        // JavaScript function to clear the form
        function clearForm() {
            document.getElementById("salaryForm").reset();
            document.getElementById("incentivesContainer").innerHTML = "";
            document.getElementById("deductionsContainer").innerHTML = "";
        }
    </script>
</body>
</html>












