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

$_SESSION['Courseid'];
$courseid = $_SESSION['Courseid'];

$courseCheck = "SELECT * FROM Courses WHERE Course_ID = '$courseid'";
$courseCheckrun = mysqli_query($conn, $courseCheck);
$courseCheckrow = mysqli_fetch_assoc($courseCheckrun);



$studentCheck = "SELECT * FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student'";
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
                    <a href="exam-report.php"><button class="go-back-btn">GO BACK</button></a>
                </div>
                <div class="exam-report-clicked">
                    <div class="row category-details">
                        <div class="col-sm-12 category-info">
                            <h2><?php echo "{$courseCheckrow['CourseName']}";?></h2>
                            <br>
                            <div class="additional-info">
                                <div class="rectangle-col">
                                    <div class="rectangle">
                                        <div class="rectangle-details">
                                            <p><strong>Total Students</strong></p>
                                            <p><?php echo "{$countStudentrow['count(ReferenceNo)']}" ?></p>
                                        </div>
                                    </div>
                            </div>
                            <div class="rectangle-col">
                                    <div class="rectangle">
                                        <div class="rectangle-details"  style="color:green;">
                                            <p><strong>Total Passed</strong></p>
                                            <p><?php echo "{$totalPassed}/{$countStudentrow['count(ReferenceNo)']}" ?></p>
                                        </div>
                                    </div>
                            </div>
                            <div class="rectangle-col">
                                    <div class="rectangle">
                                        <div class="rectangle-details"  style="color:red;">
                                            <p><strong>Total Failed</strong></p>
                                            <p><?php echo "{$totalFailed}/{$countStudentrow['count(ReferenceNo)']}" ?></p>
                                        </div>
                                    </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row category-details" style='Width:100%;'>
                        <div class="search-table">
                        <form method="post">
                            <input type="text" name="search">
                            <button type="submit" id="submit">🔍</button>
                        </form>
                    </div>
                        <div class="col-sm-12 attendance">
                            
                            <table>
                            <th colspan="4" style="color:#6C99EE;">EXAM LIST</th>
                            <th colspan="3">
                                <a href="pdfgenerator.php" target="_blank">
                                    <button class="add-exam" type="button">DOWNLOAD PDF</button>
                                </a>
                            </th>
                                <tr style="background-color:#6C99EE; color:white;">
                                    <th>STUDENT NAME</th>
                                    <th>STATUS </th>
                                    <th>EXAMS</th>
                                    <th>PERFORMANCE</th>
                                    <th>CONTROL NO.</th>
                                    <th>DATE TAKEN</th>
                                    <th></th>
                                </tr>
                                <?php
                                    if(isset($_POST['search'])){
                                        $search = $_POST['search'];
                                        $finder = "SELECT DISTINCT student_result.ReferenceNo FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE  Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student' AND Student_Accounts.FirstName LIKE '$search%' OR Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student' AND Student_Accounts.LastName LIKE '$search%'";
                                        $finderrun = mysqli_query($conn, $finder);
                                        if($search != "" && mysqli_num_rows($finderrun) > 0){
                                        while($finderrows = mysqli_fetch_assoc($finderrun)){
                                            $currentStudent = $finderrows['ReferenceNo'];
                                            $getName = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$currentStudent'";
                                            $getNamerun = mysqli_query($conn, $getName);
                                            $getNamerow = mysqli_fetch_assoc($getNamerun);
                                            echo "<tr>";
                                            echo "<td>{$getNamerow['FirstName']} {$getNamerow['LastName']}</td>";
                                            $studentCheckrun = mysqli_query($conn, $studentCheck);
                                            $studPassed = 0;
                                            $studFailed = 0;
                                            $studentAnswer = "SELECT * FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE Student_Accounts.ReferenceNo = '$currentStudent' AND Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student'";
                                            $studentAnswerrun = mysqli_query($conn, $studentAnswer);

                                            while($studentAnswerrow = mysqli_fetch_assoc($studentAnswerrun)){                             
                                                $examm = $studentAnswerrow['Exam_ID'];
                                                $examget = "SELECT * FROM Exam WHERE Exam_ID = '$examm'";
                                                $examgetrun = mysqli_query($conn, $examget);
                                                $examgetrow = mysqli_fetch_assoc($examgetrun);

                                                $examTaken = $studentAnswerrow['exam_date'];
        
                                                $currentStudent = $studentAnswerrow['ReferenceNo'];
                                                $getTotalFails = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '0'";
                                                $getTotalFailsrun = mysqli_query($conn, $getTotalFails);
                                                $getTotalFailsrow = mysqli_fetch_assoc($getTotalFailsrun);
        
                                                $getTotalPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                                $getTotalPassedrun = mysqli_query($conn, $getTotalPassed);
                                                $getTotalPassedrow = mysqli_fetch_assoc($getTotalPassedrun);
        
                                                $getTotal = $getTotalPassedrow['count(isPassed)'] + $getTotalFailsrow['count(isPassed)'];
                                                $getPassing = $getTotal * .75;

                                                $getStudPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.Exam_ID = '$examm' AND student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                                $getStudPassedrun = mysqli_query($conn, $getStudPassed);
                                                $getStudPassedrow = mysqli_fetch_assoc($getStudPassedrun);

                                                $numberPass = $getStudPassedrow['count(isPassed)'];
                                                $studPassed += $numberPass;
                                            }
                                            if($studPassed >= $getPassing){
                                                $resulting = "PASSED";
                                                echo "<td class='resulting'>{$resulting}</td>";
                                            }
                                            else{
                                                $resulting = "FAILED";
                                                echo "<td class='resulting'>{$resulting}</td>";
                                            }
                                            $performance = number_format(($studPassed / $getTotal) * 100,2);
                                            echo "<td>{$studPassed} / {$getTotal} </td>";
                                            echo "<td>{$performance}%</td>";
                                            echo "<td>{$currentStudent}</td>";
                                            echo "<td>{$examTaken}</td>";
                                            echo "<td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studentResults' hidden value='$currentStudent'><button type='submit' class='views'>VIEW</button></form></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    if($search == ""){
                                        $studentStatusrun = mysqli_query($conn, $studentStatus);
                                        while($studentStatusrow = mysqli_fetch_assoc($studentStatusrun)){
                                            $currentStudent = $studentStatusrow['ReferenceNo'];
                                            $getName = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$currentStudent'";
                                            $getNamerun = mysqli_query($conn, $getName);
                                            $getNamerow = mysqli_fetch_assoc($getNamerun);
                                            echo "<tr>";
                                            echo "<td>{$getNamerow['FirstName']} {$getNamerow['LastName']}</td>";
                                            $studentCheckrun = mysqli_query($conn, $studentCheck);
                                            $studPassed = 0;
                                            $studFailed = 0;
                                            $studentAnswer = "SELECT * FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE Student_Accounts.ReferenceNo = '$currentStudent' AND Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student'";
                                            $studentAnswerrun = mysqli_query($conn, $studentAnswer);

                                            while($studentAnswerrow = mysqli_fetch_assoc($studentAnswerrun)){                             
                                                $examm = $studentAnswerrow['Exam_ID'];
                                                $examget = "SELECT * FROM Exam WHERE Exam_ID = '$examm'";
                                                $examgetrun = mysqli_query($conn, $examget);
                                                $examgetrow = mysqli_fetch_assoc($examgetrun);

                                                $examTaken = $studentAnswerrow['exam_date'];
        
                                                $currentStudent = $studentStatusrow['ReferenceNo'];
                                                $getTotalFails = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '0'";
                                                $getTotalFailsrun = mysqli_query($conn, $getTotalFails);
                                                $getTotalFailsrow = mysqli_fetch_assoc($getTotalFailsrun);
        
                                                $getTotalPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                                $getTotalPassedrun = mysqli_query($conn, $getTotalPassed);
                                                $getTotalPassedrow = mysqli_fetch_assoc($getTotalPassedrun);
        
                                                $getTotal = $getTotalPassedrow['count(isPassed)'] + $getTotalFailsrow['count(isPassed)'];
                                                $getPassing = $getTotal * .75;

                                                $getStudPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.Exam_ID = '$examm' AND student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                                $getStudPassedrun = mysqli_query($conn, $getStudPassed);
                                                $getStudPassedrow = mysqli_fetch_assoc($getStudPassedrun);

                                                $numberPass = $getStudPassedrow['count(isPassed)'];
                                                $studPassed += $numberPass;
                                            }
                                            if($studPassed >= $getPassing){
                                                $resulting = "PASSED";
                                                echo "<td class='resulting'>{$resulting}</td>";
                                            }
                                            else{
                                                $resulting = "FAILED";
                                                echo "<td class='resulting'>{$resulting}</td>";
                                            }
                                            $performance = number_format(($studPassed / $getTotal) * 100,2);
                                            echo "<td>{$studPassed} / {$getTotal} </td>";
                                            echo "<td>{$performance}%</td>";
                                            echo "<td>{$currentStudent}</td>";
                                            echo "<td>{$examTaken}</td>";
                                            echo "<td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studentResults' hidden value='$currentStudent'><button type='submit' class='views'>VIEW</button></form></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    }
                                    else{
                                        $studentStatusrun = mysqli_query($conn, $studentStatus);
                                        while($studentStatusrow = mysqli_fetch_assoc($studentStatusrun)){
                                            $currentStudent = $studentStatusrow['ReferenceNo'];
                                            $getName = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$currentStudent'";
                                            $getNamerun = mysqli_query($conn, $getName);
                                            $getNamerow = mysqli_fetch_assoc($getNamerun);
                                            echo "<tr>";
                                            echo "<td>{$getNamerow['FirstName']} {$getNamerow['LastName']}</td>";
                                            $studPassed = 0;
                                            $studFailed = 0;

                                            $studentAnswer = "SELECT * FROM Student_Accounts INNER JOIN Student_Result ON Student_Accounts.ReferenceNo = Student_Result.ReferenceNo WHERE Student_Accounts.ReferenceNo = '$currentStudent' AND Student_Accounts.Course_ID = '$courseid' AND Account_Type = 'Student'";
                                            $studentAnswerrun = mysqli_query($conn, $studentAnswer);

                                            while($studentAnswerrow = mysqli_fetch_assoc($studentAnswerrun)){                             
                                                $examm = $studentAnswerrow['Exam_ID'];
                                                $examget = "SELECT * FROM Exam WHERE Exam_ID = '$examm'";
                                                $examgetrun = mysqli_query($conn, $examget);
                                                $examgetrow = mysqli_fetch_assoc($examgetrun);

                                                $examTaken = $studentAnswerrow['exam_date'];
        
                                                $currentStudent = $studentStatusrow['ReferenceNo'];
                                                $getTotalFails = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '0'";
                                                $getTotalFailsrun = mysqli_query($conn, $getTotalFails);
                                                $getTotalFailsrow = mysqli_fetch_assoc($getTotalFailsrun);
        
                                                $getTotalPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                                $getTotalPassedrun = mysqli_query($conn, $getTotalPassed);
                                                $getTotalPassedrow = mysqli_fetch_assoc($getTotalPassedrun);
        
                                                $getTotal = $getTotalPassedrow['count(isPassed)'] + $getTotalFailsrow['count(isPassed)'];
                                                $getPassing = $getTotal * .75;

                                                $getStudPassed = "SELECT count(isPassed) FROM student_result INNER JOIN student_accounts ON student_result.ReferenceNo = student_accounts.ReferenceNo INNER JOIN courses ON student_accounts.Course_ID = courses.Course_ID WHERE student_result.Exam_ID = '$examm' AND student_result.ReferenceNo = '$currentStudent' AND student_result.isPassed = '1'";
                                                $getStudPassedrun = mysqli_query($conn, $getStudPassed);
                                                $getStudPassedrow = mysqli_fetch_assoc($getStudPassedrun);

                                                $numberPass = $getStudPassedrow['count(isPassed)'];
                                                $studPassed += $numberPass;
                                            }
                                            if($studPassed >= $getPassing){
                                                $resulting = "PASSED";
                                                echo "<td class='resulting'>{$resulting}</td>";
                                            }
                                            else{
                                                $resulting = "FAILED";
                                                echo "<td class='resulting'>{$resulting}</td>";
                                            }
                                            $performance = number_format(($studPassed / $getTotal) * 100,2);
                                            echo "<td>{$studPassed} / {$getTotal} </td>";
                                            echo "<td>{$performance}%</td>";
                                            echo "<td>{$currentStudent}</td>";
                                            echo "<td>{$examTaken}</td>";
                                            echo "<td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studentResults' hidden value='$currentStudent'><button type='submit' class='views'>VIEW</button></form></td>";
                                            echo "</tr>";
                                        }
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

