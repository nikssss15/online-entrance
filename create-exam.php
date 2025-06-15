
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

$categories = "SELECT * FROM Category";
$categoriesrun = mysqli_query($conn, $categories);

$courses = "SELECT * FROM Courses";
$coursesrun = mysqli_query($conn, $courses);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="create-exam.css">
    <link rel="stylesheet" href="table-design.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/Layout/logo1.png"/>
</head>
<body>
    <div class="nav-bar">
        <div class="row no-gutters">
            <div class="col-sm-12">
                <div class="left">
                
                <a href="#"><img src="images/Layout/logo.png"></a>
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
                    <h1>CREATE EXAM</h1>
                </div><br><br>
                <div class="name"><b>CREATE A NEW EXAM</b></div>
                <div class="back">
                    <br>
                    <form method="POST" action="create-exam-code.php">
                        <div class="create-exam1">
                            <label for="exam-name">Exam Name*</label>
                            <input type="text" id="exam-name" name="exam-name" required>
                        </div>
                        <div class="create-exam1">
                            <?php
                            echo "<label for='categories'>Category*</label>";
                            echo "<select id='categories' name='categories' required>";
                            echo "<option value=''>Select Category</option>";
                            while($categoriesrow = mysqli_fetch_assoc($categoriesrun)){
                                echo "<option value='{$categoriesrow['Category_ID']}'>{$categoriesrow['CategoryName']}</option>";
                            }
                            echo "</select>";
                            ?>
                        </div>
                        <div class="create-exam1">
                            <label for="courses[]">Courses*</label>
                        </div>
                        <div class="create-exam2">
                            <?php
                            while($coursesrow = mysqli_fetch_assoc($coursesrun)){
                                echo "<label><input type='checkbox' name='courses[]' value='{$coursesrow['Course_ID']}'> {$coursesrow['CourseName']} </label>";
                            }
                            ?>
                        </div>
                        <div class="create-exam1">
                            <label for="description">Description*</label>
                            <textarea id="description" name="description" required></textarea>
                        </div>
                        <div class="bttns">
                            <a href="manage-exam.php"><button type="button" class="btn cancel">CANCEL</button></a>
                            <button type="submit" class="btn next">NEXT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>