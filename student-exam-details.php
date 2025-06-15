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

$studentno = $_SESSION['logged'];
$examid = $_SESSION['studexam'];

$examname = "SELECT * FROM Exam INNER JOIN Category ON Exam.Category_ID = Category.Category_ID WHERE Exam_ID = '$examid'";
$examnamerun = mysqli_query($conn, $examname);
$examnamerow = mysqli_fetch_assoc($examnamerun);

$countQuestions = "SELECT count(Question_ID) FROM Questions WHERE Exam_ID = '$examid'";
$countQuestionrun = mysqli_query($conn, $countQuestions);
$countQuestionrow = mysqli_fetch_assoc($countQuestionrun);
$countQuestionConverted = floatval($countQuestionrow['count(Question_ID)']);


$questionNames = "SELECT * FROM Questions INNER JOIN Student_Answers ON Questions.Question_ID = Student_Answers.Question_ID WHERE Student_Answers.ReferenceNo = '$studentno'";
$questionNamesrun = mysqli_query($conn, $questionNames);
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
    <link rel="stylesheet" href="exam-result.css">
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
                <h6>STUDENTS</h6>
                <a href="manage-student.html"><div class="side-nav-btn">TAKE EXAM</div></a>
                <hr>
                <h6>EXAMS</h6>
                <a href="student-exams.html"><div class="side-nav-btn">EXAMS</div></a>
            </div>
            <div class="col-sm-10">
                <div class="page-title">
                    <h1>EXAM RESULTS</h1>
                </div>
                <div class="content-table">
                    <div class="row results">
                        <div class="col-sm-12 result-details">
                            <h3><?php echo $examnamerow['ExamName'];?></h3>
                            <div class="mini-details">
                                <p>CATEGORY: <?php echo $examnamerow['CategoryName'];?></p>
                                <p><?php echo $countQuestionConverted;?> Questions</p>
                            </div>
                        </div>
                    </div>
                    <?php 
                    while($questionNamesrow = mysqli_fetch_assoc($questionNamesrun)){
                        echo
                        "
                        <div class='row question-answers'>
                        <div class='col-sm-12 my-questions'>
                            <p>{$questionNamesrow['QuestionName']}</p>
                            <div class='my-answers'>
                                <div class='answer-col'>
                                    <div>
                                        <input type='radio' id='answer1' name='answer'>
                                        <label for='answer1'>A: Answer1</label>
                                    </div>
                                    <div>
                                        <input type='radio' id='answer3' name='answer'>
                                        <label for='answer3' class='answer-right-side'>A: Answer3</label>
                                    </div>
                                </div>
                                <div class='answer-col'>
                                    <div>
                                        <input type='radio' id='answer2' name='answer'>
                                        <label for='answer2'>A: Answer2</label>
                                    </div>
                                    <div>
                                        <input type='radio' id='answer4' name='answer'>
                                        <label for='answer4' class='answer-right-side'>A: Answer4</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        ";
                    }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!--<div class="table-container">
                    <table>
                        <tr style="color:#6C99EE;">
                            <th colspan="5">EXAM LIST</th>
                        </tr>
                        <tr style="background-color:#6C99EE; color:white;">
                            <th>EXAM NAME</th>
                            <th>DESCRIPTION</th>
                            <th>SCHEDULE</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>placeholder, placeholder, placeholder</td>
                            <td>placeholder, placeholder, placeholder</td>
                            <td>placeholder, placeholder, placeholder</td>
                            <td>placeholder, placeholder, placeholder</td>
                            <td class='table-btn'><form method='POST' action='view.php'><input type='text' name='manexam' hidden value='#'><button type='submit' class='views'>VIEW</button></form></td>
                        </tr>
                    </table>
                    </div>-->