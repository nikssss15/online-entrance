<?php 

session_start();

if(isset($_POST['viewresults'])){
    if(!empty($_SESSION['viewresults'])){
        unset($_SESSION['viewresults']);
    }

    $_SESSION['viewresults'] = $_POST['viewresults'];
    
    header("location:scoredetails.php");
}

?>