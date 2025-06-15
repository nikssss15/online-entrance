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

$tableresult = "SELECT Exam.Exam_ID, Exam.ExamName, Exam.Description, Courses.ExamDate FROM Exam INNER JOIN Courses ON Exam.Course_ID = Courses.Course_ID INNER JOIN student_accounts ON student_accounts.Course_ID = Courses.Course_ID";
$tableresultrun = mysqli_query($conn, $tableresult);


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
                    <h1>RESULTS</h1>
                </div>
                <div class="content-table">
                    <div class="table-container">
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
                        <?php
                            while($tableresultrow = mysqli_fetch_assoc($tableresultrun)){
                                $examid = $tableresultrow['Exam_ID'];
                                $status = "SELECT count(Question_ID) FROM Questions WHERE Exam_ID = '$examid'";
                                $statusrun = mysqli_query($conn, $status);
                                $statusrow = mysqli_fetch_assoc($statusrun); 
                                $questionCount = floatval($statusrow['count(Question_ID)']);

                                $status = .75 * $questionCount;

                                $totalscore = "SELECT TotalScore FROM Student_Result WHERE ReferenceNo = '$studentno'";
                                $totalscorerun = mysqli_query($conn, $totalscore);
                                $totalscorerow = mysqli_fetch_assoc($totalscorerun); 
                                $totalScoreConverted = floatval($totalscorerow['TotalScore']);

                                if($totalScoreConverted >= $status){
                                    $studentstat = "PASSED";
                                }
                                else{
                                    $studentstat = "FAILED";
                                }

                                $ref = $tableresultrow['Exam_ID'];
                                echo"
                                <tr>
                                <td>{$tableresultrow['ExamName']}</td>
                                <td>{$tableresultrow['Description']}</td>
                                <td>{$tableresultrow['ExamDate']}</td>
                                <td>{$studentstat}</td>
                                <td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studexam' hidden value='$ref'><button type='submit' class='views'>VIEW</button></form></td>
                                </tr>";
                            }
                        ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>