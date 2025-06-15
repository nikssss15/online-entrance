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

if(empty($_SESSION['viewresults'])){
    header("location:view-exams.php");
}
$examID = $_SESSION['viewresults'];
$studentName = $_SESSION["logged"];

$categoryCheck = "SELECT * FROM Category WHERE Category_ID = (SELECT Category_ID FROM Exam WHERE Exam_ID = '$examID')";
$categoryCheckrun = mysqli_query($conn, $categoryCheck);
$categoryCheckrow = mysqli_fetch_assoc($categoryCheckrun);

$examCheck = "SELECT * FROM Exam WHERE Exam_ID = '$examID'";
$examCheckrun = mysqli_query($conn, $examCheck);
$examCheckrow = mysqli_fetch_assoc($examCheckrun);
$examName = $examCheckrow['ExamName'];

$questionCheck = "SELECT * FROM Questions WHERE ExamName = '$examName'";
$questionCheckrun = mysqli_query($conn, $questionCheck);
$questionCheckrow = mysqli_fetch_assoc($questionCheckrun);

$questionChecks = "SELECT * FROM Questions WHERE ExamName = '$examName' ";
$questionChecksrun = mysqli_query($conn, $questionCheck);

$countCheck = "SELECT count(Question_ID) FROM Questions WHERE ExamName = '$examName'";
$countCheckrun = mysqli_query($conn, $countCheck);
$countCheckrow = mysqli_fetch_assoc($countCheckrun);

$resultCheck = "SELECT * FROM Student_Result WHERE ReferenceNo = '$studentName' AND Exam_ID = '$examID'";
$resultCheckrun = mysqli_query($conn,$resultCheck);
$resultCheckrow = mysqli_fetch_assoc($resultCheckrun);


$countQuestions = "SELECT count(Question_ID) FROM Questions WHERE ExamName = '$examName'";
$countQuestionsrun = mysqli_query($conn, $countQuestions);
$countQuestionsrow = mysqli_fetch_assoc($countQuestionsrun);

$passing = .75 * $countQuestionsrow['count(Question_ID)'];
$total = $resultCheckrow['TotalScore'];
if($total >= $passing){
    $result = "PASSED";
    
}
else{
    $result = "FAILED";
}

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
    <link rel="stylesheet" href="exam-report.css">
    <link rel="stylesheet" href="exam-result.css">
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
                    <h1>EXAM REPORTS</h1>
                    <a href="view-exams.php"><button class="go-back-btn">GO BACK</button></a>
                </div>
                <div class="exam-report-clicked">
                    <div class="row category-details">
                        <div class="col-sm-12 category-info">
                            <h2><?php echo "{$categoryCheckrow['CategoryName']} || {$examCheckrow['ExamName']}" ?></h2>
                            <p><?php echo "{$countCheckrow['count(Question_ID)']} "?> Question</p>
                            <div class="additional-info">
                                <div class="rectangle-col">
                                    <div class="rectangle">
                                        <div class="rectangle-details">
                                            <p><strong>Total Score</strong></p>
                                            <p style='padding-left:10px;'><?php echo "{$total}"; ?></p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="rectangle-col">
                                    <div class="rectangle">
                                        <div class="rectangle-details">
                                            <p><strong>Status</strong></p>
                                            <p style='padding-left:10px;'><?php echo "{$result}"; ?></p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
                        <?php 
                        $num = 1;
                                while($questionChecksrow = mysqli_fetch_assoc($questionChecksrun)){
                                    $questionID = $questionChecksrow['Question_ID'];
                                    $questionCorrect = $questionChecksrow['CorrectAnswer'];
                                    $answerCheck = "SELECT * FROM Student_Answers WHERE ReferenceNo = '$studentName' And Question_ID = '$questionID'";
                                    $answerCheckrun = mysqli_query($conn, $answerCheck);
                                    $answerCheckrow = mysqli_fetch_assoc($answerCheckrun);
                                    echo"<div class='row question-answers' style='width:80%;'>";
                                    echo"<div class='col-sm-12 my-questions'>";
                                    echo"<p>{$num}: {$questionChecksrow['QuestionName']}</p>";
                                        echo"<div class='my-answers'>";
                                        echo"<div class='answer-col'>";
                                            echo"<div>";
                                                    echo"<input type='radio' id='answer1' name='answer' disabled>";
                                                    echo"<label for='answer1'>  {$questionChecksrow['Answer1']}</label>";
                                                    echo"</div>";
                                                echo"<div>";
                                                echo"<input type='radio' id='answer3' name='answer' disabled>";
                                                    echo"<label for='answer3' class='answer-right-side'> {$questionChecksrow['Answer3']}</label>";
                                                    echo"</div>";
                                                echo"</div>";
                                            echo"<div class='answer-col'>";
                                            echo"<div>";
                                                echo"<input type='radio' id='answer2' name='answer' disabled>";
                                                    echo"<label for='answer2'> {$questionChecksrow['Answer2']}</label>";
                                                echo"</div>";
                                                echo"<div>";
                                                    echo"<input type='radio' id='answer4' name='answer' disabled>";
                                                    echo"<label for='answer4' class='answer-right-side'> {$questionChecksrow['Answer4']}</label>";
                                                echo"</div>";
                                            echo"</div>";
                                            if (empty($answerCheckrow['Answer'])){
                                                echo "<p><strong> Your Answer: No Answer </strong></p>";
                                            }
                                            else{
                                                echo "<p><strong> Your Answer: {$answerCheckrow['Answer']}</strong></p>";
                                            }
                                        echo"</div>";
                                    echo"</div>";
                                    echo"</div>";
                                    $num++;
                                }
                            ?>
                </div>
            </div>
        </div>
    </div>
    <script src="datechecker.js"></script>
</body>
</html>