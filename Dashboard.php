<?php

session_start();

$server = "localhost";
$username = "root";
$password = "";
$db_name = "pracEntranceExam";

$conn = mysqli_connect($server, $username, $password, $db_name);

if(empty($_SESSION['logged'])){
    header("location:index.php");
}

$nostudent = "SELECT count(ReferenceNo) FROM Student_Accounts WHERE Account_Type = 'student'";
$nostudentrun = mysqli_query($conn, $nostudent);
$nostudentrow = mysqli_fetch_assoc($nostudentrun);

$adminName = $_SESSION["logged"];

    $getadmin = "SELECT * FROM Student_Accounts WHERE referenceno = '$adminName'";
    $getadminrun = mysqli_query($conn, $getadmin);
    $getadminrow = mysqli_fetch_assoc($getadminrun);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="studentdashboard.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/Layout/logo1.png"/>
</head>
<body>
    <div class="nav-bar">
        <div class="row no-gutters">
            <div class="col-sm-12">
                <div class="left">
                <a href="Dashboard.php"><img src="images/Layout/logo.png"></a>
                </div>
                <div class="nav-log-off"><a href="logout.php"><img src="images/Layout/power-off.png"></a></div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="row mainrow">
        <div class="col-sm-2">
            <div class="sticky-wrapper">
                <div class="sticky-sm-2">
                    <h6>STUDENTS</h6>
                    <a href="manage-student-courses.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> MANAGE STUDENTS</div></a>
                    <hr>
                    <h6>EXAMS</h6>
                    <a href="manage-exam.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> MANAGE EXAMS</div></a>
                    <hr>
                    <h6>REPORTS</h6>
                    <a href="exam-report.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> EXAM REPORTS</div><br></a>
                    <a href="adminfeedback.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> FEEDBACKS</div><br></a>
                </div>
            </div>
        </div>
            <div class="col-sm-10">
                <div class="dashboard">
                    <div class="row">
                    <div class="col-sm-12 user-details">
                <img src="images/Layout/logo2.png" alt="LOGO" class="dashboard-image">
                <div class="user-names">
                    <div class="user-text"><?php echo "HI! " . strtoupper($getadminrow['FirstName']) . " " . strtoupper($getadminrow['LastName']);?></div>
                    <div class="active-text">ALWAYS STAY UPDATED IN THE PORTAL</div>
                </div>
            </div>
            <div class="row align-left">
    <div class="small-box">
        <div class="text-container">
            <img src="calendar.png" alt="Academic Year Icon" class="icon">
            <div class="text-content">
                <div class="hello-text" style="font-size: 25px;"> 2023  - 2024 </div>
                <div class="calendar-text">ACADEMIC YEAR</div>
            </div>
        </div>
    </div>

    <div class="small-box exam-status">
        <div class="text-container">
            <img src="edit.png" alt="Edit Icon" class="icon">
            <div class="text-content">
                <div class="exam-status-text" style="font-size: 25px;"> <?php echo "{$nostudentrow['count(ReferenceNo)']}";?></div>
                <div class="number-text">TOTAL STUDENTS</div>
            </div>
        </div>
    </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>