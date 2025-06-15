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

if(!empty($_SESSION['usedEmail'])){
    echo "<script>alert('Email already in use.');</script>";
    unset($_SESSION['usedEmail']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="signupdesign.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/Layout/logo1.png"/>
    <title>Sign Up</title>
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
                <div class="containerss">
                <div class="left-side">
                    <h5 id="form_label">SIGN UP</h5>
                    <div class="signup">
                    <form action = "send.php" method="POST">
                        <div class="col-sm-12">
                            <label for="firstname">First name*</label><br>
                            <input type="text" id="firstname" name="fname" value="" required>
                        </div>
                        <div class="col-sm-12" id="lmnamestack">
                            <div id="stack1">
                                <label for="lastname">Last name*</label><br>
                                <input type="text" id="lastname" name="lname" value="" required>
                            </div>                       
                            <div id="stack2">
                                 <label for="middlename">Middle name</label><br>
                                <input type="text" id="middlename" name="mname" value="">
                            </div>
                        </div>    
                        <div class="col-sm-12" id="lmnamestack">
                            <div id="stack1">
                                <label for="birthdate">Birthdate*</label><br>
                                <input type="date" id="birthdate" name="bdate" value="" required>
                            </div>                      
                            <div id="stack2">
                                 <label for="gender">Gender*</label><br>
                                 <select id="gender" name="gender" required>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="Course">Course*</label><br>
                            <select id="Course" name="Course" required>
                                    <option>BSIT</option>
                                    <option>BSPSY</option>
                                    <option>BSCS</option>
                                    <option>BSBA</option>
                                    <option>BSHM</option>
                                </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="contact">Contact*</label><br>
                            <input type="number" id="contact" name="contact" value="" required>
                        </div>
                        <div class="col-sm-12">
                            <label for="address">Address*</label><br>
                            <input type="text" id="address" name="address" value="" required>
                        </div>    
                        <div class="col-sm-12">
                            <label for="guardian">Guardian*</label><br>
                            <input type="text" id="guardian" name="guardian" value="" required>
                        </div>
                        <div class="col-sm-12">
                            <label for="gcontact">Guardian Contact*</label><br>
                            <input type="number" id="gcontact" name="gcontact" value="" required>
                        </div>
                        <div class="col-sm-12">
                            <label for="email">Email*</label><br>
                            <input type="email" id="email" name="email" value="" required>
                        </div>
                        <div class="row">                          
                            <div class="col-sm-12" id="submit-button">
                            <button type="submit" name="send">Submit</button>
                            <p >Already have an account? <a href="index.php">Sign In</a></p>
                        </div>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="right-side">
                    <img src="IMAGES/signup/campus1.png">
                </div>
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