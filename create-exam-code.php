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

if(isset($_POST['exam-name']) && isset($_POST['categories']) && isset($_POST['courses']) && isset($_POST['description'])){
    $_SESSION['examname'] = $_POST['exam-name'];
    $examname = $_SESSION['examname'];
    $category = $_POST['categories'];
    $description = $_POST['description'];

    foreach ($_POST['courses'] as $course_id){
        $insertexam = "INSERT INTO Exam(`Course_ID`, `Category_ID`, `ExamName`, `Description`) VALUES('$course_id', '$category', '$examname', '$description')";
        mysqli_query($conn, $insertexam);
    }
    header("location:create-questions.php"); // Redirect after successful insertion
    exit;
}

else{
    header("location:create-exam.php");
    exit;
}

if(isset($_POST['finish'])){
    echo "<script>alert('Exam Successfully Created');</script>";
    header("location:manage-exam.php");

}

else{
    echo "<script>alert('Exam Successfully Created');</script>";
}

?>