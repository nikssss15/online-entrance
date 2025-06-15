
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

if(isset($_POST['timer']) && isset($_POST['courses']) && isset($_POST['date']) && isset($_POST['scoredate'])){
    $timer = $_POST['timer'];
    $score = $_POST['scoredate'];
    $date = $_POST['date'];

    foreach ($_POST['courses'] as $course_id){        
        $insertdate = "UPDATE Courses SET ExamDate = '$date' WHERE Course_ID = '$course_id'";
        mysqli_query($conn, $insertdate);

        $insertscoredate = "UPDATE Courses SET ScoreDate = '$score' WHERE Course_ID = '$course_id'";
        mysqli_query($conn, $insertscoredate);

        $inserttimer = "UPDATE Courses SET Timer = '$timer' WHERE Course_ID = '$course_id'";
        mysqli_query($conn, $inserttimer);
    }
    echo "<script>alert('Exam Successfully Created');</script>";
}

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
                    <form method="POST">
                        <div class="create-exam1">
                            <label for="time-limit">Time Limit*</label>
                            <select id="time-limit" name="timer" required>
                                <option value="">Select Time</option>
                                <option value="60">60:00</option>
                                <option value="90">90:00</option>
                                <option value="120">120:00</option>
                            </select>
                        </div>
                        <div class="create-exam1">
                            <label for="exam-date">Exam Date*</label>
                            <input type="date" id="exam-date" name="date"required>
                        </div>
                        <div class="create-exam1">
                            <label for="score-date">Score Release Date*</label>
                            <input type="date" id="score-date" name="scoredate"required>
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
                        <br>
                        <div class="bttns">
                            <a href="manage-exam.php"><button type="button" class="btn cancel">CANCEL</button></a>
                            <button type="submit" class="btn next">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>