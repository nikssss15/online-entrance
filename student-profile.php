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

$studentref = $_SESSION["logged"];
$studdets = "SELECT * FROM Student_Accounts INNER JOIN Courses ON Student_Accounts.Course_ID = Courses.Course_ID WHERE ReferenceNo = '$studentref'";
$studdetsrun = mysqli_query($conn, $studdets);
$studdetsrow = mysqli_fetch_assoc($studdetsrun);

$getStudent = "SELECT * FROM Student_Accounts WHERE ReferenceNo = '$studentref'";
$getStudentrun = mysqli_query($conn, $getStudent);
$getStudentrow = mysqli_fetch_assoc($getStudentrun);

$courseDate = "SELECT ExamDate, ScoreDate FROM Courses WHERE Course_ID = (SELECT Course_ID FROM Student_Accounts WHERE ReferenceNo = '$studentref')";
$courseDaterun = mysqli_query($conn, $courseDate);
$courseDaterow = mysqli_fetch_assoc($courseDaterun);

$courseDate = "SELECT ExamDate, ScoreDate FROM Courses WHERE Course_ID = (SELECT Course_ID FROM Student_Accounts WHERE ReferenceNo = '$studentref')";
$courseDaterun = mysqli_query($conn, $courseDate);
$courseDaterow = mysqli_fetch_assoc($courseDaterun);

if(isset($_POST['pfpsubmit'])){
    $fileName = $_FILES['pfppic']['name'];
    $fileTmpName = $_FILES['pfppic']['tmp_name'];
    $fileSize = $_FILES['pfppic']['size'];
    $fileType = $_FILES['pfppic']['type'];

    $destination = 'IMAGES/StudentPics/' . $fileName;
    move_uploaded_file($fileTmpName, $destination);

    $pfpChecker = "SELECT * FROM student_pics WHERE ReferenceNo = '$studentref'";
    $pfpCheckerrun = mysqli_query($conn, $pfpChecker);
    $pfpCheckerrow = mysqli_fetch_assoc($pfpCheckerrun);
    if($rowcount = mysqli_num_rows($pfpCheckerrun) > 0){
        $pfpUpload = "UPDATE student_pics SET `FileName` = '$fileName' WHERE ReferenceNo = '$studentref'";
        $pfpUploadrun = mysqli_query($conn, $pfpUpload);
    }
    else{
        $pfpUpload = "INSERT INTO student_pics(`FileName`, `ReferenceNo`) VALUES ('$fileName', $studentref)";
        $pfpUploadrun = mysqli_query($conn, $pfpUpload);
    }
}
    
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
                
                <a href="studentdashboard.php"><img src="images/Layout/logo3.png"></a>
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
                <h6>STUDENT PROFILE</h6>
                <a href='student-profile.php'>
                <div class='side-nav-btn'>
                <img src='images/Layout/user.png' alt='User Icon'> PROFILE
                </div>
                </a>
                <hr>
                <?php
                    $currentDate = date("Y-m-d");
                    if($currentDate != $courseDaterow['ExamDate']){
                        echo "<h6 class='no-date'>AVAILABLE EXAMS</h6>";
                        echo "<a a href='#' onclick='alert(\"Exam Not Yet Available\")'>";
                            echo "<div class='side-nav-btn2'>";
                                echo "<img src='images/Layout/user.png' alt='User Icon'> TAKE EXAM";
                            echo "</div>";
                        echo "</a>";
                    }
                    elseif($currentDate == $courseDaterow['ExamDate']){
                        echo "<h6>AVAILABLE EXAMS</h6>";
                        echo "<a href='#' onclick=\"confirmation()\">";
                        echo "<div class='side-nav-btn'>";
                        echo "<img src='images/Layout/user.png' alt='User Icon'> TAKE EXAM";
                        echo "</div>";
                        echo "</a>";
                    }
                    ?>
                    <hr>
                    <?php
                    $currentDate = date("Y-m-d");
                    if($currentDate != $courseDaterow['ScoreDate'] && $currentDate < $courseDaterow['ScoreDate']){
                        echo "<h6 class='no-date'>TAKEN EXAMS</h6>";
                        echo "<a a href='#' onclick='alert(\"Results Not Available Yet\")'>";
                            echo "<div class='side-nav-btn2'>";
                                echo "<img src='images/Layout/exam.png' alt='User Icon'> EXAM RESULT";
                            echo "</div>";
                        echo "</a>";
                    }
                    elseif($currentDate >= $courseDaterow['ScoreDate']){
                        echo "<h6>TAKEN EXAMS</h6>";
                        echo "<a href='#' onclick=\"scorechecker()\">";
                        echo "<div class='side-nav-btn'>";
                        echo "<img src='images/Layout/exam.png' alt='User Icon'> EXAM RESULT";
                        echo "</div>";
                        echo "</a>";
                    }
                    ?>
                    <hr>
                    <h6>FEEDBACKS</h6>
                    <a href='feedback.php'>
                        <div class='side-nav-btn'>
                            <img src='images/Layout/user.png' alt='User Icon'> ADD FEEDBACK
                        </div>
                    </a>
                </div>
            </div>
        </div>
            <div class="col-sm-10">
                <div class="page-title">
                    <h1>YOUR PROFILE</h1>
                </div>
                <div class="content-table">
                    <div class="box">
                        <div class="studpicture">
                        <div class="studleft">
                        <img src="IMAGES/StudentPics/<?php echo "$studentPic"; ?>">
                        <div class="detail profile-pic">
                            <form method="POST" enctype="multipart/form-data">
                            <input type="file" name='pfppic' id='pfp' accept="image/png, image/jpeg">
                            <input type="submit" name="pfpsubmit" id='pfpsubmit' hidden>
                            </form>
                        </div>
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
                        <div class="detail change">
                            <a href="change-pass.php">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="datechecker.js"></script>
    <script>
    var uploadField = document.getElementById("pfp");

    uploadField.onchange = function() {
    if(this.files[0].size > 2097152) {
       alert("File is too big!");
       this.value = "";
    }
    else{
        let pfpchange = confirm("Are you sure you want to change your profile picture?");
        if(pfpchange){
            document.getElementById("pfpsubmit").click();
        }
    }
};
    </script>
</body>
</html>