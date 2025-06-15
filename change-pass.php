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

$courseDate = "SELECT ExamDate, ScoreDate FROM Courses WHERE Course_ID = (SELECT Course_ID FROM Student_Accounts WHERE ReferenceNo = '$studentref')";
$courseDaterun = mysqli_query($conn, $courseDate);
$courseDaterow = mysqli_fetch_assoc($courseDaterun);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="create-exam.css">
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
                <br>
                <br>
                <div class="password-change">
                    <div class="name"><b>CHANGE YOUR PASSWORD</b></div>
                    <div class="back">
                        <form method="POST">
                            <br>
                            <div class="create-exam1">
                                <label for="exam-name">Enter Current Password*</label>
                                <input type="password" id="Current" name="Current" required>
                            </div>
                            <hr>
                            <div class="create-exam1">
                                <label for="exam-name">Enter New Password*</label>
                                <input type="password" id="New-Pass" name="New-Pass" required>
                            </div>
                            <div class="create-exam1">
                                <label for="exam-name">Confirm New Password*</label>
                                <input type="password" id="Confirm-Pass" name="Confirm-Pass" required>
                            </div>
                            <p class='confirm-pass'>New Password Must Match the Current Password.</p>
                            <p class='confirm-pass'>Confirm Passwords Must Match.</p>
                            <p class='confirm-pass'>Password Must Be Greater Than 8 Characters.</p>
                            <p class='confirm-pass'>Password Must Contain Numbers.</p>
                            <p class='confirm-pass'>Password Must Contain Uppercase Letters.</p>
                            <p class='confirm-pass'>Password Must Contain Special Characters.</p>
                            <div class="bttns">
                                <a href="student-profile.php"><button type="button" class="btn cancel">CANCEL</button></a>
                                <button type="submit" class="btn next">UPDATE</button>
                            </div>
                        </form>


                        <?php 
                        
                        if(isset($_POST['Current']) && isset($_POST['New-Pass']) && isset($_POST['Confirm-Pass'])){
                            $currentPass = $_POST['Current'];
                            $newPass = $_POST['New-Pass'];
                            $confirmPass = $_POST['Confirm-Pass'];
                            $studentPass = "SELECT `Password` FROM Student_Accounts WHERE ReferenceNo = '$studentref'";
                            $studentPassrun = mysqli_query($conn, $studentPass);
                            $studentPassrow = mysqli_fetch_assoc($studentPassrun);
                        
                            $correctPass = 0;
                            $errorPass = ""; // Initialize the errorPass variable
                            $containNumber = "/[0-9]/";
                            $containUpper = "/[A-Z]/";
                            $containSpecial = "/[^a-zA-Z0-9\s]/";
                            if($currentPass == $studentPassrow['Password']){
                                $correctPass++;
                            }
                            if($newPass == $confirmPass && $correctPass == 1){
                                $correctPass++;
                            }
                            if(strlen($newPass) >= 8  && $correctPass == 2){
                                $correctPass++;
                            }
                            if(preg_match($containNumber, $newPass) && $correctPass == 3){
                                $correctPass++;
                            }
                            if(preg_match($containUpper, $newPass) && $correctPass == 4){
                                $correctPass++;
                            }
                            if(preg_match($containSpecial, $newPass) && $correctPass == 5){
                                $correctPass++;
                            }
                        
                            switch($correctPass){
                                case 0:
                                    $errorPass = "Current Password Incorrect.";
                                    break;
                                case 1:
                                    $errorPass = "Confirm Password Does Not Match.";
                                    break;
                                case 2:
                                    $errorPass = "Password Length Must Be Greater Than 8 Characters.";
                                    break;
                                case 3:
                                    $errorPass = "Password Must Contain Numbers.";
                                    break;
                                case 4:
                                    $errorPass = "Password Must Contain Uppercase Letters.";
                                    break;
                                case 5:
                                    $errorPass = "Password Must Contain Special Characters.";
                                    break;
                                case 6:
                                    $changePass = "UPDATE Student_Accounts SET `Password` = '$newPass' WHERE ReferenceNo = '$studentref'";
                                    $changePassrun = mysqli_query($conn, $changePass);
                                    echo "<script>document.getElementById('successBtn').click();</script>";
                                    break;
                            }
                        }

                        ?>

                        <button type="button" id="errorBtn" hidden onclick='alert("<?php echo $errorPass; ?>")'><?php echo "$errorPass"; ?></button>
                        <button type="button" id="successBtn" hidden onclick='alert("Password Successfully Changed.")'></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="datechecker.js"></script>
    <script>
        function changePass(){
            if(document.getElementById('errorBtn').innerText.trim() === ""){
                document.getElementById('successBtn').click();
            }
            else{
                document.getElementById('errorBtn').click();
            }
        }
        changePass();
    </script>
</body>
</html>