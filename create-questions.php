
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

if(empty($_SESSION['examname'])){
    header("location:create-exam.php");
}

$questionname = $_SESSION['examname'];

$questions = "SELECT * FROM Questions WHERE ExamName = '$questionname'";
$questionsrun = mysqli_query($conn, $questions);
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
    <link rel="stylesheet" href="create-questions.css">
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
                    <a href="add-questions.php"><button class="add-exam" type="button">+ADD QUESTIONS</button></a>
                    <br>
                    <br>
                            <div class="create-questions">
                                <?php
                                $num = 1; 
                                while($questionsrow = mysqli_fetch_assoc($questionsrun)){
                                    $ref = $questionsrow['Question_ID'];
                                    echo"<div class='question-item'>";
                                        echo"<p>{$num}: {$questionsrow['QuestionName']}</p>";
                                        echo"<div class='answers'>";
                                            echo"<div class='answers-design'>";
                                            echo"<p><strong>Correct Answer </strong></p>";
                                            echo"<p>{$questionsrow['CorrectAnswer']}</p>";
                                            echo"</div>";
                                            echo"<div class='remove'>";
                                            echo"<form method='POST' action='remove.php'><input type='text' name='remove' hidden value='$ref'><button type='submit' class='DeleteQuestion'>🗑️</button></form>";
                                            echo"</div>";
                                        echo"</div>";
                                    echo"</div>";
                                    $num++;
                                }
                                echo "</div>";
                                ?>
                                <br>
                                <div class="bttns">
                                <form method="POST" action="finishexam.php"><input type="text" name="finish" hidden value="Finish"><button type="submit" class="btn next">FINISH</button></form>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>