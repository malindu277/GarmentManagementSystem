<?php
    include 'config.php';
    
    if(isset($_POST['generate_report'])) {
        $month = $_POST['month'];
        
        
        $sql = "SELECT salary.empId, employee.name, salary.TotSalary FROM salary INNER JOIN employee ON salary.empId = employee.empId WHERE salary.month = '$month'";
        $result = $conn->query($sql);

        
        require('fpdf/fpdf.php');
        
        class PDF extends FPDF {
        
            function Header() {
               
                $this->Image('Screenshot 2024-03-29 103430.png',10,6,30);
                $this->SetFont('Arial','B',14);
                $this->Cell(0,10,'Dil Fashion',0,1,'C');
               
                $this->SetFont('Arial','I',10);
                $this->Cell(0,10,'Your Fashion Destination',0,1,'C');
                
                $this->Ln(10);
            }

            // Footer
            function Footer() {
                
                $this->SetY(-15);
               
                $this->SetFont('Arial','I',8);
             
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            }
        }

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'Salary Report for '.$month,0,1,'C');
        $pdf->Ln(10);

        
        $currentDate = date('Y-m-d');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0,10,'Date: ' . $currentDate,0,1);

       
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(40,10,'Employee ID',1,0,'C');
        $pdf->Cell(80,10,'Name',1,0,'C');
        $pdf->Cell(70,10,'Total Salary',1,1,'C');

       
        $pdf->SetFont('Arial','',10);
        $totalSalaries = 0;
        while($row = $result->fetch_assoc()) {
            $pdf->Cell(40,10,$row["empId"],1,0);
            $pdf->Cell(80,10,$row["name"],1,0);
            $pdf->Cell(70,10,'Rs. ' . number_format($row["TotSalary"]),1,1);
            $totalSalaries += $row["TotSalary"];
        }

        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(120,10,'Grand Total',1,0,'R');
        $pdf->Cell(70,10,'Rs. ' . number_format($totalSalaries),1,1);

      
        
        $pdf->Ln(20);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,10,'',0,1); 
        $pdf->Cell(60,10,'..........................',0,0); 
        $pdf->Cell(0,10,'',0,1); 
        $pdf->Cell(60,10,'Mrs. E.M. Sumudu Dilhani',0,1); 
        $pdf->Cell(60,10,'Manager',0,1); 
        $pdf->Cell(60,10,'Dil Fashion',0,1); 

        
        $pdf->Cell(0,10,'',0,1); 
        $pdf->Cell(60,10,'..........................',0,0); 
        $pdf->Cell(0,10,'',0,1); 
        $pdf->Cell(60,10,'Mr. E.W. Chaminda Prabhath',0,1); 
        $pdf->Cell(60,10,'Manager',0,1); 
        $pdf->Cell(60,10,'Dil Fashion',0,1); 

        
   
        $pdf->Output();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        .custom-header {
            background-color: #000080;
        }
    </style>
</head>
<body>
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
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-3">Generate Salary Report</h2>
                        <form id="reportForm" action="" method="post">
                            <div class="form-group">
                                <label for="month">Select Month</label>
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
                            <button type="submit" class="btn btn-primary" name="generate_report">Generate Report</button>
                            <a href="EmpDash.html" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-5">
        <div class="container">
            <p class="text-muted text-center">© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var month = document.getElementById('month').value;
            if(month === "") {
                alert("Please select a month.");
                return;
            }
            
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'empreport.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.responseType = 'blob';
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    var blob = new Blob([xhr.response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'SalaryReport.pdf';
                    link.click();
                }
            };
            xhr.send('generate_report=true&month=' + month);
        });
    </script>
</body>
</html>










