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

if(!empty($_SESSION['examid'])){
    unset($_SESSION['examid']);
}

$studentName = $_SESSION["logged"];

$goBack = "SELECT * FROM Student_Result WHERE ReferenceNo = '$studentName'";
$goBackrun = mysqli_query($conn, $goBack);

if($goBacknum = mysqli_num_rows($goBackrun) <= 0){
    echo 
        "<script> 
                alert('You need to take the exams first before you check your results.');
                history.back();
        </script>";

}

$viewtable = "SELECT * FROM Student_Result WHERE ReferenceNo = $studentName";
$viewtablerun = mysqli_query($conn, $viewtable);

$courseDate = "SELECT ExamDate, ScoreDate FROM Courses WHERE Course_ID = (SELECT Course_ID FROM Student_Accounts WHERE ReferenceNo = '$studentName')";
$courseDaterun = mysqli_query($conn, $courseDate);
$courseDaterow = mysqli_fetch_assoc($courseDaterun);
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
                <div class="page-title">
                    <h1>MANAGE EXAMS</h1>
                </div>
                <div class="content-table">
                    <div class="table-container">
                    <table>
                        <tr style="color:#6C99EE;">
                            <th colspan="4">EXAM LIST</th>
                        </tr>
                        <tr style="background-color:#6C99EE; color:white;">
                            <th>EXAM NAME</th>
                            <th>CATEGORY</th>
                            <th>RESULT</th>
                            <th></th>
                        </tr>
                        <?php 
                            while($viewtablerow = mysqli_fetch_assoc($viewtablerun)){
                                $ref = $viewtablerow['Exam_ID'];
                                $examName = "SELECT * FROM Exam WHERE Exam_ID = '$ref'";
                                $examNamerun = mysqli_query($conn, $examName);
                                $examNamerow = mysqli_fetch_assoc($examNamerun);
                                $getExamName = $examNamerow['ExamName'];

                                $categoryName = "SELECT * FROM Category WHERE Category_ID = (SELECT Category_ID FROM Exam WHERE Exam_ID = '$ref')";
                                $categoryNamerun = mysqli_query($conn, $categoryName);
                                $categoryNamerow = mysqli_fetch_assoc($categoryNamerun);
                                
                                $countQuestions = "SELECT count(Question_ID) FROM Questions WHERE ExamName = '$getExamName'";
                                $countQuestionsrun = mysqli_query($conn, $countQuestions);
                                $countQuestionsrow = mysqli_fetch_assoc($countQuestionsrun);

                                $passing = .75 * $countQuestionsrow['count(Question_ID)'];
                                $total = $viewtablerow['TotalScore'];

                                if($total >= $passing){
                                    $result = "PASSED";
                                    
                                }
                                else{
                                    $result = "FAILED";
                                }
                                
                                echo"<tr>";
                                        
                                echo"<td>{$examNamerow['ExamName']}</td>";
                                echo"<td>{$categoryNamerow['CategoryName']}</td>";
                                echo"<td>{$result}</td>";
                                echo "<td class='table-btn'>";
                                echo "<form method='POST' action='studentview.php'>";
                                echo "<input type='text' name='viewresults' hidden value='$ref'>";
                                echo "<button type='submit' class='views'>VIEW</button>";
                                echo "</form>";
                                echo "</td>";
                                echo"</tr>";
                                
                            }
                        ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="datechecker.js"></script>
</body>
</html>