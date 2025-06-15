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

if(empty($_SESSION['examid'])){
    header("location:manage-exam-2.php");
}

if(isset($_POST['remove'])){
    $examid = $_SESSION['examid'];
    $removeexam = "DELETE FROM Exam WHERE Exam_ID = '$examid'";
    mysqli_query($conn, $removeexam);
    
    header("location:manage-exam.php");
}

?>