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

if(empty($_SESSION['studentref'])){
    header("location:manage-student.php");
}
$studentref = $_SESSION['studentref'];
$studdets = "SELECT * FROM Student_Accounts INNER JOIN Courses ON Student_Accounts.Course_ID = Courses.Course_ID WHERE ReferenceNo = '$studentref'";
$studdetsrun = mysqli_query($conn, $studdets);
$studdetsrow = mysqli_fetch_assoc($studdetsrun);

$pfpChecker = "SELECT * FROM student_pics WHERE ReferenceNo = '$studentref'";
$pfpCheckerrun = mysqli_query($conn, $pfpChecker);
$pfpCheckerrow = mysqli_fetch_assoc($pfpCheckerrun);
$studentPic = "aaa.png";
if($rowcount = mysqli_num_rows($pfpCheckerrun) > 0){
    $studentPic = $pfpCheckerrow['FileName'];
}
else{
    $studentPic = "aaa.png";
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
                    <h1>STUDENT DETAILS</h1>
                    <a href="manage-student.php"><button class="go-back-btn">GO BACK</button></a>
                </div>
                <div class="content-table">
                    <div class="box">
                        <div class="studpicture">
                        <div class="studleft">
                        <img src="IMAGES/StudentPics/<?php echo "$studentPic"; ?>">
                        </div>
                        <div class="studright">
                        <h2>Personal Information</h2>
                        <div class="detail">
                            <label for="fullname">Fullname:</label>
                            <input disabled type="text" id="fullname" name="fullname" value="<?php echo $studdetsrow['FirstName'] . ' ' . $studdetsrow['MiddleName'] . ' ' . $studdetsrow['LastName'];?>">
                        </div>
                        <div class="detail">
                            <label for="birthdate">Birthdate:</label>
                            <input disabled type="date" id="birthdate" name="birthdate" value = "<?php echo $studdetsrow['Birthdate']?>">
                        </div>
                        </div>
                        </div>
                        <div class="detail">
                            <label for="Course">Course:</label>
                            <input disabled type="text" id="Course" name="Course" value = "<?php echo $studdetsrow['CourseName']?>">
                        </div>
                        <div class="detail">
                            <label for="sex">Sex:</label>
                            <input disabled type="text" id="sex" name="sex" value = "<?php echo $studdetsrow['Gender']?>">
                        </div>
                        <div class="detail">
                            <label for="contact">Contact:</label>
                            <input disabled type="text" id="contact" name="contact" value = "<?php echo '0' . $studdetsrow['Contact']?>">
                        </div>
                        <div class="detail">
                            <label for="email">Email:</label>
                            <input disabled type="email" id="email" name="email" value = "<?php echo $studdetsrow['Email']?>">
                        </div>
                        <h2>Contact Details</h2>
                        <div class="detail">
                            <label for="address">Address:</label>
                            <input disabled type="text" id="address" name="address" value = "<?php echo $studdetsrow['Address']?>">
                        </div>
                        <div class="detail">
                            <label for="guardian">Guardian:</label>
                            <input disabled type="text" id="guardian" name="guardian" value = "<?php echo $studdetsrow['Guardian']?>">
                        </div>
                        <div class="detail">
                            <label for="contact-number">Contact Number:</label>
                            <input disabled type="text" id="contact-number" name="contact-number" value = "<?php echo '0' . $studdetsrow['GuardianContact']?>">
                        </div>
                        <h2>Portal Account</h2>
                        <div class="detail">
                            <label for="ReferenceNo">Control Number:</label>
                            <input disabled type="email" id="ReferenceNo" name="ReferenceNo" value = "<?php echo $studdetsrow['ReferenceNo']?>">
                        </div>
                        <div class="detail">
                            <label for="password">Password:</label>
                            <input disabled type="password" id="password" name="password" value = "<?php echo $studdetsrow['Password']?>">
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>