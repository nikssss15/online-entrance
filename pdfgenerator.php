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

$courseName = $courseCheckrow['CourseName'];

    require('fpdf/fpdf.php');

    $pdf = new FPDF('P', 'mm', "A4");

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(63, 10, '', 0, 0);
    $pdf->Cell(63, 10, 'INNOVATEU TECHNOLOGICAL INSTITUTION', 0, 0, 'C');
    $pdf->Cell(63, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(63, 5, '', 0, 0);
    $pdf->Cell(63, 5, 'CAVITE', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 14);
    
    $pdf->Cell(63, 10, '', 0, 0);
    $pdf->Cell(63, 10, 'EXAM REPORTS', 0, 0, 'C');
    $pdf->Cell(63, 10, '', 0, 1);

    $pdf->Cell(63, 10, '', 0, 0);
    $pdf->Cell(63, 10, '', 0, 0, 'C');
    $pdf->Cell(63, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 11);
    
    $pdf->Cell(63, 5, "Course: $courseName", 0, 0);
    $pdf->Cell(63, 5, '', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 1);

    $pdf->Cell(63, 5, '', 0, 0);
    $pdf->Cell(63, 5, '', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 1);

    $pdf->Cell(63, 5, "Total Passed: {$totalPassed}/{$countStudentrow['count(ReferenceNo)']} ", 0, 0);
    $pdf->Cell(63, 5, '', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 1);

    $pdf->Cell(63, 5, '', 0, 0);
    $pdf->Cell(63, 5, '', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 1);

    $pdf->Cell(63, 5, "Total Failed: {$totalFailed}/{$countStudentrow['count(ReferenceNo)']}", 0, 0);
    $pdf->Cell(63, 5, '', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 1);
    $pdf->Cell(63, 6, '', 0, 1);

    $pdf->Cell(38, 5, 'STUDENT NAME', 1, 0,);
    $pdf->Cell(24, 5, 'STATUS ', 1, 0,);
    $pdf->Cell(24, 5, 'EXAMS ', 1, 0,);
    $pdf->Cell(38, 5, 'PERFORMANCE ', 1, 0,);
    $pdf->Cell(33, 5, 'CONTROL NO ', 1, 0,);
    $pdf->Cell(31, 5, 'DATE TAKEN ', 1, 0,);
    $pdf->Cell(63, 6, '', 0, 1);

    $pdf->SetFont('Arial', '', 9);
    $studentStatusrun = mysqli_query($conn, $studentStatus);

    while($studentStatusrow = mysqli_fetch_assoc($studentStatusrun)){
        $currentStudent = $studentStatusrow['ReferenceNo'];
        $getName = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$currentStudent'";
        $getNamerun = mysqli_query($conn, $getName);
        $getNamerow = mysqli_fetch_assoc($getNamerun);
        $pdf->Cell(38, 8, "{$getNamerow['FirstName']} {$getNamerow['LastName']}", 1, 0,);
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
            $pdf->Cell(24, 8, "{$resulting}", 1, 0,'C');
        }
        else{
            $resulting = "FAILED";
            $pdf->Cell(24, 8, "{$resulting}", 1, 0,'C');
        }
        $performance = number_format(($studPassed / $getTotal) * 100,2);
        $pdf->Cell(24, 8, "{$studPassed} / {$getTotal}", 1, 0,'C');
        $pdf->Cell(38, 8, "{$performance}%", 1, 0,'C');
        $pdf->Cell(33, 8, "{$currentStudent}", 1, 0,'C');
        $pdf->Cell(31, 8, "{$examTaken}", 1, 0, 'C');

        $pdf->Cell(63, 9, '', 0, 1);
    }

    $date = date("Y-m-d");
    
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(63, 5, '', 0, 1);
    $pdf->Cell(188, 5, 'Electronic Copy of Exam Report | InnovateU Technological Institution', 0, 0,);
    $pdf->Cell(63, 6, '', 0, 1);
    $pdf->Cell(188, 5, "Date Generated: $date", 0, 0,);
    $pdf->Cell(63, 6, '', 0, 1);

    

    $pdf->Output();

?>