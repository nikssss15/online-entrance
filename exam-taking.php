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

$getExams = "SELECT ExamName FROM Exam INNER JOIN Student_Accounts ON Exam.Course_ID = Student_Accounts.Course_ID WHERE Exam.Course_ID = '$studentName'";
$getExamsrun = mysqli_query($conn, $getExams);

$getStudent = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$studentName'";
$getStudentrun = mysqli_query($conn, $getStudent);
$getStudentrow = mysqli_fetch_assoc($getStudentrun);

$studentCourse = $getStudentrow['Course_ID'];

$getExam = "SELECT * FROM Exam WHERE Course_ID = '$studentCourse' AND Exam_ID NOT IN (SELECT Exam_ID FROM Student_Result WHERE ReferenceNo = '$studentName') LIMIT 1";

$getExamrun = mysqli_query($conn, $getExam);
$getExamrow = mysqli_fetch_assoc($getExamrun);

if (!$getExamrow) {
    header("location:exams.php");
}

$examName = $getExamrow['ExamName'];
$examId = $getExamrow['Exam_ID'];
$_SESSION['examname'] = $examName;
$_SESSION['examid'] = $examId;

$getQuestions = "SELECT * FROM Questions WHERE ExamName = '$examName'";
$getQuestionsrun = mysqli_query($conn, $getQuestions);

$getTimer = "SELECT * FROM Courses WHERE Course_ID = '$studentCourse'";
$getTimerrun = mysqli_query($conn, $getTimer);
$getTimerrow = mysqli_fetch_assoc($getTimerrun);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="studentdashboard.css">
    <link rel="stylesheet" href="exam-taking.css">
    <script>
        function submitConfirm(form){
            let confirmation = confirm("Are you sure you want to submit? You won't be able to make any changes after submitting.");
            if (confirmation){
                return true;
            }
            else{
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="nav-bar">
        <div class="row no-gutters">
            <div class="col-sm-12">
                <div class="left">
                
                <a href="#"><img src="IMAGES/Layout/logo3.png"></a>
                </div>
                <div class="nav-log-off"><a href="#"><img src="images/Layout/power-off.png"></a></div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="row mainrow">
        <div class="col-sm-2">
            <div class="sticky-wrapper">
                <div class="sticky-sm-2">
                    <h6 class='no-date'>STUDENT PROFILE</h6>
                    <a href='#' onclick='alert("Cant Perform Action While Taking The Exam.")'>
                    <div class='side-nav-btn2'>
                    <img src='images/Layout/user.png' alt='User Icon'> PROFILE
                    </div>
                    </a>
                    <hr>
                <?php
                    echo "<h6 class='no-date'>AVAILABLE EXAMS</h6>";
                    echo "<a a href='#' onclick='alert(\"Youre Already Taking The Exam.\")'>";
                        echo "<div class='side-nav-btn2'>";
                            echo "<img src='images/Layout/user.png' alt='User Icon'> TAKE EXAM";
                        echo "</div>";
                    echo "</a>";
                ?>
                <hr>
                <?php
                    echo "<h6 class='no-date'>TAKEN EXAMS</h6>";
                    echo "<a a href='#' onclick='alert(\"Cant Perform Action While Taking The Exam.\")'>";
                        echo "<div class='side-nav-btn2'>";
                            echo "<img src='images/Layout/exam.png' alt='User Icon'> EXAM RESULT";
                        echo "</div>";
                    echo "</a>";
                ?>
                <hr>
                <h6 class='no-date'>FEEDBACKS</h6>
                    <a href='#' onclick='alert("Cant Perform Action While Taking The Exam.")'>
                        <div class='side-nav-btn2'>
                            <img src='images/Layout/user.png' alt='User Icon'> ADD FEEDBACK
                        </div>
                    </a>
                </div>
            </div>
        </div>
            <div class="col-sm-10 containers">
                <div class="exam-container">
                    <div class="row exam2">
                        <div class="timer-sec">
                            <div class="timer">
                                <span id="minutes"><?php echo $getTimerrow['Timer']; ?></span>
                                <span> : </span>
                                <span id="seconds">00</span>
                            </div>
                        </div>
                    </div>
                    <div class="row exam">
                            <div class="col-sm-12 exam-details2">
                                <div class="exam-name-desc">
                                    <p><?php echo "<strong>{$getExamrow['ExamName']}</strong>"; ?></p>
                                    <p><?php echo "{$getExamrow['Description']}"; ?></p>
                                </div>
                            </div>
                        <div class="col-sm-12 pages">
                        </div>
                    </div>
                    <div class="row questions">
                        <form method="POST" id="submit-exam" action="submit-exam.php" onsubmit="return submitConfirm()">
                        <?php
                            $questionnum = 1;
                            while($getQuestionsrow = mysqli_fetch_assoc($getQuestionsrun)){
                                $questionid = $getQuestionsrow['Question_ID'];
                                echo "<div class='col-sm-12 exam-questions'>";
                                echo "<div class='question-desc'>";
                                    echo "<p><strong>{$questionnum}: {$getQuestionsrow['QuestionName']}</strong></p>";
                                echo "</div>";
                                echo "<div class='answers-container'>";
                                    echo "<div class='answers-align'>";
                                        echo "<div class='answers'><div style='border-right:1px solid;'><input type='radio' id = 'answer_{$questionid}' name='answer[$questionid]' value='{$getQuestionsrow['Answer1']}' required></div><p>{$getQuestionsrow['Answer1']}</p></div>";
                                        echo "<div class='answers'><div style='border-right:1px solid;'><input type='radio' id = 'answer_{$questionid}' name='answer[$questionid]' value='{$getQuestionsrow['Answer2']}'></div><p>{$getQuestionsrow['Answer2']}</p></div>";
                                        echo "<div class='answers'><div style='border-right:1px solid;'><input type='radio' id = 'answer_{$questionid}' name='answer[$questionid]' value='{$getQuestionsrow['Answer3']}'></div><p>{$getQuestionsrow['Answer3']}</p></div>";
                                        echo "<div class='answers'><div style='border-right:1px solid;'><input type='radio' id = 'answer_{$questionid}' name='answer[$questionid]' value='{$getQuestionsrow['Answer4']}'></div><p>{$getQuestionsrow['Answer4']}</p></div>";
                                    echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                $questionnum++;
                            }
                            
                        ?>
                        <div class="submit-btn"><button type="submit">Submit Answer</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="timer.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('input[id^="answer_"]');
            
            inputs.forEach(input => {
                // Check the radio button that was saved in sessionStorage
                const savedAnswer = sessionStorage.getItem(input.name);
                if (savedAnswer && input.value === savedAnswer) {
                    input.checked = true;
                }

                // Save the selected radio button to sessionStorage when it is clicked
                input.addEventListener('change', function () {
                    sessionStorage.setItem(input.name, input.value);
                });
            });
        });

        window.addEventListener('load', function () {
            const inputs = document.querySelectorAll('input[id^="answer_"]');
            
            inputs.forEach(input => {
                const savedAnswer = sessionStorage.getItem(input.name);
                if (savedAnswer && input.value === savedAnswer) {
                    input.checked = true;
                }
            });
        });
    </script>
</body>
</html>