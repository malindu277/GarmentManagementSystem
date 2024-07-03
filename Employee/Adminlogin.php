<?php

include 'config.php';


session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = "admin1";
    $password = "admin1234";
    if ($_POST["username"] == $username && $_POST["password"] == $password) {
        
        echo "<script>window.location.href = 'home.html';</script>";
        exit; 
    } else {
       
        echo "<script>alert('Invalid username or password');</script>";
    }
}

if(isset($_POST['logout']) && $_POST['logout'] === 'true') {
    
    session_start();
    session_unset();
    session_destroy();
    header("Location: Adminlogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-v7fAUyAX6IJJShqGk4XLnW+ZS5i3UKW/AdrKp+5lB9WKc2Hv6x4h5X8x/KUpQaPbAR7gHPHY6ulx1onfj/Bgpw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        
        .custom-header {
            background-color: #000080; 
        }
        footer {
            background-color: #343a40; 
            color: white;
            text-align: center;
            padding: 15px;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('SL-022722-48830-13.jpg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 0;
        }
        .myform {
            background-color: rgba(255, 255, 255, 0.5); 
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .myform h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-primary {
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            background-color: #000080;
            border: none;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #001a40;
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

    <main>
        
        <div class="myform">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>ADMIN LOGIN</h2>
                <div class="form-group">
                    <input type="text" name="username" placeholder="Admin Name">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password">
                    <i class="fas fa-lock"></i>
                </div>
                <button class="btn btn-primary" type="submit">LOGIN</button>
            </form>
        </div>
    </main>

   
    <footer>
        <div class="container">
            <p>© 2024 Employee Portal. All Rights Reserved.</p>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-x7N+KI2TFzJBCjL4+Zeu/JyUOv8Zs7ZGwIDyoF9h9H/15B5E9wJZvp7SE9mQJVvTtwrvuqdHcKc2S6ZK2GmkRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>



