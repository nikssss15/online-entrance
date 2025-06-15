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

if(isset($_POST['finish'])){
    header("location:manage-exam.php");
    echo "<script> alert('Exam Created Successfully') </script>";

}

?>