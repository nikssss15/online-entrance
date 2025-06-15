<?php 

session_start();

if(isset($_POST['studdet'])){
    if(!empty($_SESSION['studentref'])){
        unset($_SESSION['studentref']);
    }

    $_SESSION['studentref'] = $_POST['studdet'];

    header("location:student-details.php");
}

if(isset($_POST['manexam'])){
    if(!empty($_SESSION['examid'])){
        unset($_SESSION['examid']);
    }
    $_SESSION['examid'] = $_POST['manexam'];
    header("location:manage-exam-2.php");
}


if(isset($_POST['studexam'])){
    if(!empty($_SESSION['studexam'])){
        unset($_SESSION['studexam']);
    }
    $_SESSION['studexam'] = $_POST['studexam'];
    header("location:student-exam-details.php");
}

if(isset($_POST['studentResults'])){
    if(!empty($_SESSION['studentResults'])){
        unset($_SESSION['studentResults']);
    }
    $_SESSION['studentResults'] = $_POST['studentResults'];
    header("location:exam-report-clicked2.php");
}

if(isset($_POST['feedbackGo'])){
    if(!empty($_SESSION['feedbackGo'])){
        unset($_SESSION['feedbackGo']);
    }
    $_SESSION['feedbackGo'] = $_POST['feedbackGo'];
    header("location:feedback-details.php");
}

?>