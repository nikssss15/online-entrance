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

$studentName = $_SESSION["logged"];

$getStudent = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$studentName'";
$getStudentrun = mysqli_query($conn, $getStudent);
$getStudentrow = mysqli_fetch_assoc($getStudentrun);

$courseDate = "SELECT ExamDate, ScoreDate FROM Courses WHERE Course_ID = (SELECT Course_ID FROM Student_Accounts WHERE ReferenceNo = '$studentName')";
$courseDaterun = mysqli_query($conn, $courseDate);
$courseDaterow = mysqli_fetch_assoc($courseDaterun);


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="layout.css" />
    <link rel="stylesheet" href="exams.css" />
  </head>
  <body>
  <div class="nav-bar">
        <div class="row">
            <div class="col-sm-12">
                <div class="left">
                
                <a href="studentdashboard.php"><img src="IMAGES/Layout/logo3.png"></a>
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
                <h6>STUDENT PROFILE</h6>
                <a href='student-profile.php'>
                <div class='side-nav-btn'>
                <img src='images/Layout/user.png' alt='User Icon'> PROFILE
                </div>
                </a>
                <hr>
                <?php
                    $currentDate = date("Y-m-d");
                    if($currentDate != $courseDaterow['ExamDate']){
                        echo "<h6 class='no-date'>AVAILABLE EXAMS</h6>";
                        echo "<a a href='#' onclick='alert(\"Exam Not Yet Available\")'>";
                            echo "<div class='side-nav-btn2'>";
                                echo "<img src='images/Layout/user.png' alt='User Icon'> TAKE EXAM";
                            echo "</div>";
                        echo "</a>";
                    }
                    elseif($currentDate == $courseDaterow['ExamDate']){
                        echo "<h6>AVAILABLE EXAMS</h6>";
                        echo "<a href='#' onclick=\"confirmation()\">";
                        echo "<div class='side-nav-btn'>";
                        echo "<img src='images/Layout/user.png' alt='User Icon'> TAKE EXAM";
                        echo "</div>";
                        echo "</a>";
                    }
                    ?>
                    <hr>
                    <?php
                    $currentDate = date("Y-m-d");
                    if($currentDate != $courseDaterow['ScoreDate'] && $currentDate < $courseDaterow['ScoreDate']){
                        echo "<h6 class='no-date'>TAKEN EXAMS</h6>";
                        echo "<a a href='#' onclick='alert(\"Results Not Available Yet\")'>";
                            echo "<div class='side-nav-btn2'>";
                                echo "<img src='images/Layout/exam.png' alt='User Icon'> EXAM RESULT";
                            echo "</div>";
                        echo "</a>";
                    }
                    elseif($currentDate >= $courseDaterow['ScoreDate']){
                        echo "<h6>TAKEN EXAMS</h6>";
                        echo "<a href='#' onclick=\"scorechecker()\">";
                        echo "<div class='side-nav-btn'>";
                        echo "<img src='images/Layout/exam.png' alt='User Icon'> EXAM RESULT";
                        echo "</div>";
                        echo "</a>";
                    }
                    ?>
                    <hr>
                    <h6>FEEDBACKS</h6>
                    <a href='feedback.php'>
                        <div class='side-nav-btn'>
                            <img src='images/Layout/user.png' alt='User Icon'> ADD FEEDBACK
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-10">
          <div class="col-sm-10">
            <div style="width: 100%">
              <div class="buttons" style="float: right; margin-top: 10px">
                <a href="studentdashboard.php">
                  <button class="go-back-btn">GO BACK</button>
                  </a>
              </div>
            </div>
            <div class="dashboard">
              <div class="row">
                <div class="col-sm-12">
                  <div class="examname-text"><?php echo "Hi " . $getStudentrow['FirstName'] . " " . $getStudentrow['LastName'] ."!"; ?></div>
                  <div class="response-text">
                    YOUR RESPONSE HAS ALREADY BEEN RECORDED. PLEASE WAIT FOR THE RELEASE OF THE RESULTS
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="datechecker.js"></script>
  </body>
</html>
