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

if(!empty($_SESSION['studentref'])){
    unset($_SESSION['studentref']);
}

$courses = "SELECT * FROM Courses";
$coursesrun = mysqli_query($conn, $courses);


$categoryNames = "SELECT * FROM Category INNER JOIN Exam ON Category.Category_ID = Exam.Category_ID";
$categoryNamesrun = mysqli_query($conn, $categoryNames);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="table-design.css">
    <link rel="stylesheet" href="exam-report.css">
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
                <div class="page-title">
                    <h1>EXAM REPORTS</h1>
                </div>
                <div class="exam-reporting">
                    <?php 
                    
                    while($coursesrow = mysqli_fetch_assoc($coursesrun)){
                        $ref = $coursesrow['Course_ID'];
                        echo "<form method='POST' action='exam-report-code.php'>";
                        echo "<input type='text' name='courses' hidden value='$ref'>";
                        echo "<button type='submit' style='width:100%; background:transparent;border-radius:5px; border:none;'>";
                        echo "<div class='exam-category'>";
                        echo "<p>{$coursesrow['CourseName']}</p>";
                        echo "</div>";
                        echo "</button>";
                        echo "</form>";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>