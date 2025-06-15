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

if(isset($_POST['QuestionName']) && isset($_POST['Answer1']) && isset($_POST['Answer2']) && isset($_POST['Answer3']) && isset($_POST['Answer4']) && isset($_POST['answers'])){
    $examname = $_SESSION['examname'];
    $QuestionName = $_POST['QuestionName'];
    $Answer1 = $_POST['Answer1'];
    $Answer2 = $_POST['Answer2'];
    $Answer3 = $_POST['Answer3'];
    $Answer4 = $_POST['Answer4'];
    $answers = $_POST['answers'];

    $insertquestion = "INSERT INTO `Questions`(`QuestionName`, `Answer1`, `Answer2`, `Answer3`, `Answer4`, `CorrectAnswer`, `ExamName`) VALUES ('$QuestionName','$Answer1','$Answer2','$Answer3','$Answer4','$answers', '$examname')";
    mysqli_query($conn, $insertquestion);

    header("location:create-questions.php"); // Redirect after successful insertion
    exit;
}

else{
    header("location:create-questions.php"); // Redirect after successful insertion
    exit;
}

?>