<?php

session_start();

if(isset($_POST['courses'])){
    $courses = $_POST['courses'];
    $_SESSION['Courseid'] = $courses;

    header('location:exam-report-clicked.php');
}
else{
    header('location:exam-report.php');
}


?>
