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

if(isset($_POST['timer']) && isset($_POST['courses']) && isset($_POST['date']) && isset($_POST['scoredate'])){
    $timer = $_POST['timer'];
    $score = $_POST['scoredate'];
    $date = $_POST['date'];

    foreach ($_POST['courses'] as $course_id){        
        $insertdate = "UPDATE Courses SET ExamDate = '$date' WHERE Course_ID = '$course_id'";
        mysqli_query($conn, $insertdate);

        $insertscoredate = "UPDATE Courses SET ScoreDate = '$score' WHERE Course_ID = '$course_id'";
        mysqli_query($conn, $insertscoredate);

        $inserttimer = "UPDATE Courses SET Timer = '$timer' WHERE Course_ID = '$course_id'";
        mysqli_query($conn, $inserttimer);
    }
    echo "<script>alert('Schedule and Timer Successfully Changed.');</script>";
}