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

if(!empty($_SESSION['studentref'])){
    unset($_SESSION['studentref']);
}

$courses = $_SESSION['Courseid'];

$tablestudents = "SELECT * FROM Student_Accounts INNER JOIN Courses ON Student_Accounts.Course_ID = Courses.Course_ID WHERE Student_Accounts.Account_Type='Student' AND Student_Accounts.Course_ID = '$courses' ORDER BY ReferenceNo";
$tablestudentsrun = mysqli_query($conn, $tablestudents);


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
                    <a href="manage-student.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> MANAGE STUDENTS</div></a>
                    <hr>
                    <h6>EXAMS</h6>
                    <a href="manage-exam.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> MANAGE EXAMS</div></a>
                    <hr>
                    <h6>REPORTS</h6>
                    <a href="exam-report.php"><div class="side-nav-btn"><img src="images/Layout/user.png" alt="User Icon"> EXAM REPORTS</div><br></a>
                </div>
            </div>
        </div>
            <div class="col-sm-10">
                <div class="page-title">
                    <h1>MANAGE STUDENTS</h1>
                </div>
                <div class="content-table">
                    <div class="search-table">
                        <form method="post">
                            <input type="text" name="search">
                            <button type="submit" id="submit">🔍</button>
                        </form>
                    </div>
                    <table>
                        <tr style="color:#6C99EE;">
                            <th colspan="6">STUDENTS</th>
                        </tr>
                        <tr style="background-color:#6C99EE; color:white;">
                            <th>STUDENT NAME</th>
                            <th>COURSE</th>
                            <th>BIRTHDAY</th>
                            <th>EMAIL</th>
                            <th>REFERENCE</th>
                            <th></th>
                        </tr>
                        <?php
                            if(isset($_POST['search'])){
                                $search = $_POST['search'];
                                $finder = "SELECT * FROM Student_Accounts INNER JOIN Courses ON Student_Accounts.Course_ID = Courses.Course_ID WHERE FirstName LIKE '$search%' OR LastName LIKE '$search%'";
                                $finderrun = mysqli_query($conn, $finder);
                                if($search != "" && mysqli_num_rows($finderrun) > 0){
                                    while($finderrows = mysqli_fetch_assoc($finderrun)){
                                        $ref = $finderrows['ReferenceNo'];
                                        echo 
                                        "<tr>
                                        <td>{$finderrows['FirstName']} {$finderrows['LastName']}</td>
                                        <td>{$finderrows['CourseName']}</td>
                                        <td>{$finderrows['Birthdate']}</td>
                                        <td>{$finderrows['Email']}</td>
                                        <td>{$finderrows['ReferenceNo']}</td>
                                        <td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studdet' hidden value='$ref'><button type='submit' class='views'>VIEW</button></form></td>
                                        </tr>";
                                    }
                                }
                                if($search == ""){
                                    while($tablestudentsrow = mysqli_fetch_assoc($tablestudentsrun)){
                                        $ref = $tablestudentsrow['ReferenceNo'];
                                        echo"
                                                <tr>
                                                <td>{$tablestudentsrow['FirstName']} {$tablestudentsrow['LastName']}</td>
                                                <td>{$tablestudentsrow['CourseName']}</td>
                                                <td>{$tablestudentsrow['Birthdate']}</td>
                                                <td>{$tablestudentsrow['Email']}</td>
                                                <td>{$tablestudentsrow['ReferenceNo']}</td>
                                                <td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studdet' hidden value='$ref'><button type='submit' class='views'>VIEW</button></form></td>
                                                </tr>";
                                        }
                                }
                            }
                            else{
                                while($tablestudentsrow = mysqli_fetch_assoc($tablestudentsrun)){
                                $ref = $tablestudentsrow['ReferenceNo'];
                                echo"
                                        <tr>
                                        <td>{$tablestudentsrow['FirstName']} {$tablestudentsrow['LastName']}</td>
                                        <td>{$tablestudentsrow['CourseName']}</td>
                                        <td>{$tablestudentsrow['Birthdate']}</td>
                                        <td>{$tablestudentsrow['Email']}</td>
                                        <td>{$tablestudentsrow['ReferenceNo']}</td>
                                        <td class='table-btn'><form method='POST' action='view.php'><input type='text' name='studdet' hidden value='$ref'><button type='submit' class='views'>VIEW</button></form></td>
                                        </tr>";
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>