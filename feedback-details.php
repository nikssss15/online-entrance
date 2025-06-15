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

if(empty($_SESSION['feedbackGo'])){
    header("location:adminfeedback2.php");
}
$studentref = $_SESSION['feedbackGo'];
$studdets = "SELECT * FROM feedbacks INNER JOIN Student_Accounts ON feedbacks.ReferenceNo = Student_Accounts.ReferenceNo WHERE Student_Accounts.ReferenceNo = '$studentref'";
$studdetsrun = mysqli_query($conn, $studdets);
$studdetsrow = mysqli_fetch_assoc($studdetsrun);

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
                    <h1>FEEDBACKS</h1>
                    <a href="adminfeedback2.php"><button class="go-back-btn">GO BACK</button></a>
                </div>
                <div class="content-table">
                    <div class="box">
                        <h2>Feedback Information</h2>
                        <div class="detail">
                            <label for="fullname">Fullname:</label>
                            <input disabled type="text" id="fullname" name="fullname" value="<?php echo $studdetsrow['FirstName'] . ' ' . $studdetsrow['MiddleName'] . ' ' . $studdetsrow['LastName'];?>">
                        </div>
                        <div class="detail">
                            <label for="birthdate">Feedback Date:</label>
                            <input disabled type="date" id="birthdate" name="birthdate" value = "<?php echo $studdetsrow['FeedbackDate']?>">
                        </div>
                        <div class="detail">
                            <label for="fullname">Subject:</label>
                            <input disabled type="text" id="fullname" name="fullname" value="<?php echo $studdetsrow['fb_subject'];?>">
                        </div>
                        <div class="detail fb_content">
                            <label for="Course">Course:</label>
                            <textarea disabled id="Course" name="Course" value = ""><?php echo $studdetsrow['fb_content']?></textarea>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>