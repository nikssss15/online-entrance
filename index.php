<?php 

session_start();

$server = "localhost";
$username = "root";
$password = "";
$db_name = "pracEntranceExam";

$conn = mysqli_connect($server, $username, $password, $db_name);

if(!empty($_SESSION['logged'])){
    $studentName = $_SESSION['logged'];
    $query = "SELECT ReferenceNo FROM Student_Accounts WHERE ReferenceNo = '$studentName'";
    $runquery = mysqli_query($conn, $query);
    if(mysqli_num_rows($runquery) > 0){
        $acc_type = "SELECT Account_Type FROM Student_Accounts WHERE ReferenceNo = '$studentName'";
        $checker = mysqli_query($conn, $acc_type);
        $row = mysqli_fetch_assoc($checker);

        if($row['Account_Type'] == "admin"){
            header("location:dashboard.php");
        }
        elseif($row['Account_Type'] == "student"){
            header("location:studentdashboard.php");
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="indexdesign.css">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <div class="row">
            <div class="col-sm-12"></div>
        </div>
    </div>
    <div class="form">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="left-side">
                    <h5>SIGN IN</h5>
                    <div class="login">
                    <form method="post" action="login.php">
                        <div class="row">
                            <div class="col-sm-12">
                            <label for="std_number">Control Number*</label><br>
                            <input type="text" id="std_number" name="std_number" required>
                            </div>
                            <div class="col-sm-12">
                            <label for="password">Password*</label><br>
                            <input type="password" id="password" name="password" required>
                            </div>
                            <div class="col-sm-12" id="submit-button">
                            <button type="submit">Sign In</button>
                            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="right-side">
                    <img src="images/Login/campus-image.png">
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>

    <div class="header">
        <div class="row">
            <div class="col-sm-12"></div>
        </div>
    </div>
</body>
</html>
