<?php 

session_start();

$server = "localhost";
$username = "root";
$password = "";
$db_name = "pracEntranceExam";

$conn = mysqli_connect($server, $username, $password, $db_name);

if(empty($_SESSION["logged"])){
    header("location:index.php");
}

$studentName = $_SESSION["logged"];


$examName = $_SESSION['examname'];
$examId = $_SESSION['examid'];

$countQuestions = "SELECT count(Question_ID) FROM Questions WHERE ExamName = '$examName'";
$countQuestionsrun = mysqli_query($conn, $countQuestions);
$countQuestionsrow = mysqli_fetch_assoc($countQuestionsrun);

$overallScores = $countQuestionsrow['count(Question_ID)'];
$passing = $overallScores * .75;

$totalCorrect = 0;
foreach ($_POST['answer'] as $question_id => $answer){
    $correct_answer = "SELECT CorrectAnswer FROM Questions WHERE Question_ID = '$question_id'";
    $correct_answerrun = mysqli_query($conn, $correct_answer);
    $correct_answerrow = mysqli_fetch_assoc($correct_answerrun);

    if($answer == $correct_answerrow['CorrectAnswer']){
        $isCorrect = 1;
        $totalCorrect++;
    }
    else{
        $isCorrect = 0;
    }

    if($answer == NULL || $answer == ""){
        $submitanswer = "INSERT INTO student_answers (`Question_ID`,`ReferenceNo`,`Answer`,`IsCorrect`, `Exam_ID`) VALUES('$question_id', '$studentName', 'No Answer','$isCorrect','$examId')";
        mysqli_query($conn, $submitanswer);
    }
    else{
        $submitanswer = "INSERT INTO student_answers (`Question_ID`,`ReferenceNo`,`Answer`,`IsCorrect`, `Exam_ID`) VALUES('$question_id', '$studentName', '$answer','$isCorrect','$examId')";
        mysqli_query($conn, $submitanswer);
    }
    
}

$getDate = date("Y-m-d");

$finalize = "INSERT INTO Student_Result (`ReferenceNo`, `Exam_ID`, `TotalScore`, `exam_date`) VALUES ('$studentName', '$examId', $totalCorrect, '$getDate')";
mysqli_query($conn, $finalize);

if($totalCorrect >= $passing){
    $passingcheck = "UPDATE Student_Result SET isPassed = 1 WHERE ReferenceNo = '$studentName' AND Exam_ID = '$examId'";
    mysqli_query($conn, $passingcheck);
}
else{
    $passingcheck = "UPDATE Student_Result SET isPassed = 0 WHERE ReferenceNo = '$studentName'  AND Exam_ID = '$examId'";
    mysqli_query($conn, $passingcheck);
}

$totalCorrect = 0;

header("location:exam-taking.php");

?>
