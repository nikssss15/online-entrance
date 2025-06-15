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

$getTotalFails = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '6' AND student_result.isPassed = '0'";
$getTotalFailsrun = mysqli_query($conn, $getTotalFails);
$getTotalFailsrow = mysqli_fetch_assoc($getTotalFailsrun);

$getTotalPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '6' AND student_result.isPassed = '1'";
$getTotalPassedrun = mysqli_query($conn, $getTotalPassed);
$getTotalPassedrow = mysqli_fetch_assoc($getTotalPassedrun);

$getTotal = $getTotalPassedrow['count(isPassed)'] + $getTotalFailsrow['count(isPassed)'];
$getPassing = $getTotal * .75;

$totalPassed = 0;
if($getTotalPassedrow['count(isPassed)'] >= $getPassing){
    $status = "Passed";
    $totalPassed++;
}
else{
    $status = "Failed";
}

?>

<h1>Hello</h1>
<h1>Fails : <?php echo "{$getTotalFailsrow['count(isPassed)']}"; ?> </h1>
<h1>Passes : <?php echo "{$getTotalPassedrow['count(isPassed)']}"; ?> </h1>
<h1>Total : <?php echo $getTotal ?> </h1>
<h1>Status : <?php echo $status ?> </h1>