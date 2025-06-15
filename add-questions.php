
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

if(empty($_SESSION['examname'])){
    header("location:create-exam.php");
}

$questionname = $_SESSION['examname'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="create-exam.css">
    <link rel="stylesheet" href="table-design.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/Layout/logo1.png"/>
    <script>
        function answer1(){
            document.getElementById("corAnswer1").value = document.getElementById('Answer1').value;
        }
        function answer2(){
            document.getElementById("corAnswer2").value = document.getElementById('Answer2').value;
        }
        function answer3(){
            document.getElementById("corAnswer3").value = document.getElementById('Answer3').value;
        }
        function answer4(){
            document.getElementById("corAnswer4").value = document.getElementById('Answer4').value;
        }
    </script>
</head>
<body>
    <div class="nav-bar">
        <div class="row no-gutters">
            <div class="col-sm-12">
                <div class="left">

                <a href="#"><img src="images/Layout/logo.png"></a>
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
                    <h1>CREATE EXAM</h1>
                </div><br><br>
                <div class="name"><b>CREATE A NEW EXAM</b></div>
                <div class="back">
                    <br>
                    <form method="POST" action="create-question-code.php">
                        <div class="create-exam1">
                            <label for="QuestionName">Question*</label>
                            <textarea id="QuestionName" name="QuestionName" required></textarea>
                        </div>
                        <div class="create-exam1">
                            <label for="Answer1">Choice A*</label>
                            <input type="text" id="Answer1" name="Answer1" onchange="answer1()" required>
                        </div>
                        <div class="create-exam1">
                            <label for="Answer2">Choice B*</label>
                            <input type="text" id="Answer2" name="Answer2" onchange="answer2()" required>
                        </div>
                        <div class="create-exam1">
                            <label for="Answer3">Choice C*</label>
                            <input type="text" id="Answer3" name="Answer3" onchange="answer3()" required>
                        </div>
                        <div class="create-exam1">
                            <label for="Answer4">Choice D*</label>
                            <input type="text" id="Answer4" name="Answer4" onchange="answer4()" required>
                        </div>

                        <div class="create-exam1">
                            <label for="answers">Correct Answer*</label>
                        </div>

                        <div class="choose-answers">
                            
                            <div class="ans">
                                <input type="radio" id="corAnswer1" name="answers" value="" required>
                                <label for="answers1">A</label>
                            </div>
                            
                            <div class="ans">
                                <input type="radio" id="corAnswer2" name="answers" value="" required>
                                <label for="answers2">B</label>
                            </div>
                            
                            <div class="ans">
                                <input type="radio" id="corAnswer3" name="answers" value="" required>
                                <label for="answers3">C</label>
                            </div>
                            
                            <div class="ans">
                                <input type="radio" id="corAnswer4" name="answers" value="" required>
                                <label for="answers4">D</label>
                            </div>
                            
                            
                        </div>
                        
                        <div class="bttns">
                            <a href="manage-exam.php"><button type="button" class="btn cancel">CANCEL</button></a>
                            <button type="submit" class="btn next">NEXT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>