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

if(isset($_POST['remove'])){
    $examname = $_SESSION['examname'];
    $questionid = $_POST['remove'];

    $removal = "DELETE FROM Questions WHERE Question_ID = '$questionid' AND ExamName = '$examname'";
    mysqli_query($conn, $removal);

    header("location:create-questions.php");
    exit;
}

else{
    header("location:create-questions.php");
    exit;
}

?>