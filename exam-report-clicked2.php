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

$_SESSION['studentResults'];
$studentName = $_SESSION['studentResults'];

$_SESSION['Courseid'];
$courseid = $_SESSION['Courseid'];

$courseCheck = "SELECT * FROM Courses WHERE Course_ID = '$courseid'";
$courseCheckrun = mysqli_query($conn, $courseCheck);
$courseCheckrow = mysqli_fetch_assoc($courseCheckrun);

$studentCheck = "SELECT * FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE Student_Accounts.ReferenceNo = '$studentName' AND Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student'";
$studentCheckrun = mysqli_query($conn, $studentCheck);

$examName = "SELECT * FROM Exam INNER JOIN Student_Accounts ON Exam.Course_ID = Student_Accounts.Course_ID INNER JOIN Courses ON Courses.Course_ID = Student_Accounts.Course_ID WHERE Courses.Course_ID = '$courseid'";
$examNamerun = mysqli_query($conn, $examName);
$examNamerow = mysqli_fetch_assoc($examNamerun);

$countStudent = "SELECT count(ReferenceNo) FROM Student_Accounts WHERE Course_ID = '$courseid' AND Account_Type='student'";
$countStudentrun = mysqli_query($conn, $countStudent);
$countStudentrow = mysqli_fetch_assoc($countStudentrun);

$countExam = "SELECT count(ExamName) FROM Exam WHERE Course_ID = $courseid";
$countExamrun = mysqli_query($conn, $countExam);
$countExamrow = mysqli_fetch_assoc($countExamrun);
$examNo = $countExamrow['count(ExamName)'];

$totalPassed = 0;
$totalFailed = 0;

$studentStatus = "SELECT DISTINCT student_result.ReferenceNo FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student'";
$studentStatusrun = mysqli_query($conn, $studentStatus);

while($studentStatusrow = mysqli_fetch_assoc($studentStatusrun)){
    $currentStudent = $studentStatusrow['ReferenceNo'];
    $getTotalFails = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '0'";
    $getTotalFailsrun = mysqli_query($conn, $getTotalFails);
    $getTotalFailsrow = mysqli_fetch_assoc($getTotalFailsrun);
    
    $getTotalPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
    $getTotalPassedrun = mysqli_query($conn, $getTotalPassed);
    $getTotalPassedrow = mysqli_fetch_assoc($getTotalPassedrun);
    
    $getTotal = $getTotalPassedrow['count(isPassed)'] + $getTotalFailsrow['count(isPassed)'];
    $getPassing = $getTotal * .75;
    
    if($getTotalPassedrow['count(isPassed)'] >= $getPassing){
        $status = "Passed";
        $totalPassed++;
    }
    else{
        $status = "Failed";
        $totalFailed++;
    }
}
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
    <link rel="shortcut icon" type="image/x-icon" href="images/Layout/logo1.png"/>
</head>
<body>
    <div class="nav-bar">
        <div class="row no-gutters">
            <div class="col-sm-12">
                <div class="left">
                
                <a href="Dashboard.php"><img src="images/Layout/logo.png"></a>
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
                    <h6>STUDENTS</h6>
                    <a href="manage-student-courses.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> MANAGE STUDENTS</div></a>
                    <hr>
                    <h6>EXAMS</h6>
                    <a href="manage-exam.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> MANAGE EXAMS</div></a>
                    <hr>
                    <h6>REPORTS</h6>
                    <a href="exam-report.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> EXAM REPORTS</div><br></a>
                    <a href="adminfeedback.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> FEEDBACKS</div><br></a>
                </div>
            </div>
        </div>
            <div class="col-sm-10">
                <div class="page-title">
                    <h1>EXAM REPORTS</h1>
                    <a href="exam-report-clicked.php"><button class="go-back-btn">GO BACK</button></a>
                </div>
                <div class="exam-report-clicked">
                    <div class="row category-details">
                    <div class="row category-details" style='Width:100%;'>
                        <div class="col-sm-12 attendance">
                            <table>
                                <tr style="color:#6C99EE;">
                                    <th colspan="5" >Student Reports</th>
                                </tr>
                                <tr style="background-color:#6C99EE; color:white;">
                                    <th>Student Name</th>
                                    <th>Status </th>
                                    <th>Exam </th>
                                    <th></th>
                                </tr>
                                <?php
                                    $studentCheckrun = mysqli_query($conn, $studentCheck);
                                    while($studentCheckrow = mysqli_fetch_assoc($studentCheckrun)){
                                        $examm = $studentCheckrow['Exam_ID'];
                                        $examget = "SELECT * FROM Exam WHERE Exam_ID = '$examm'";
                                        $examgetrun = mysqli_query($conn, $examget);
                                        $examgetrow = mysqli_fetch_assoc($examgetrun);
                                        if($studentCheckrow['isPassed'] == 1){
                                            $resulting = "PASSED"; 
                                        }
                                        else{
                                            $resulting = "FAILED"; 
                                        }

                                        $currentStudent = $studentCheckrow['ReferenceNo'];
                                        $getTotalFails = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '0'";
                                        $getTotalFailsrun = mysqli_query($conn, $getTotalFails);
                                        $getTotalFailsrow = mysqli_fetch_assoc($getTotalFailsrun);

                                        $getTotalPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                        $getTotalPassedrun = mysqli_query($conn, $getTotalPassed);
                                        $getTotalPassedrow = mysqli_fetch_assoc($getTotalPassedrun);

                                        $getTotal = $getTotalPassedrow['count(isPassed)'] + $getTotalFailsrow['count(isPassed)'];
                                        $getPassing = $getTotal * .75;


                                        if($getTotalPassedrow['count(isPassed)'] >= $getPassing){
                                            $status = "Passed";
                                            $totalPassed++;
                                        }
                                        else{
                                            $status = "Failed";
                                            $totalFailed++;
                                        }
                                        echo "<tr>";
                                        echo "<td>{$studentCheckrow['FirstName']} {$studentCheckrow['LastName']}</td>";
                                        echo "<td class='resulting'>{$resulting}</td>";
                                        echo "<td>{$examgetrow['ExamName']}</td>";
                                        echo "<td></td>";
                                        echo "</tr>";
                                    }
                                ?>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let colorStatus = document.getElementsByClassName("resulting");
        for(let i = 0; i<colorStatus.length; i++){
            if(colorStatus[i].innerHTML.toLowerCase() === "passed"){
                colorStatus[i].style.color = "#008000";
                colorStatus[i].style.fontWeight = "bold";
            }
            else{
                colorStatus[i].style.color = "#F95332";
                colorStatus[i].style.fontWeight = "bold";
            }
            
        }
    </script>
</body>
</html>