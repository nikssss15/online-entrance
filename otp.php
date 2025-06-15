<?php

session_start();

$server = "localhost";
$username = "root";
$password = "";
$db_name = "pracEntranceExam";

$conn = mysqli_connect($server, $username, $password, $db_name);

if(!empty($_SESSION['logged'])){
    $studentName = $_SESSION['logged'];
    $query = "SELECT ReferenceNo FROM Student_Accounts WHERE ReferenceNo = '$studentName'";
    $runquery = mysqli_query($conn, $query);
    if(mysqli_num_rows($runquery) > 0){
        $acc_type = "SELECT Account_Type FROM Student_Accounts WHERE ReferenceNo = '$studentName'";
        $checker = mysqli_query($conn, $acc_type);
        $row = mysqli_fetch_assoc($checker);

        if($row['Account_Type'] == "admin"){
            header("location:dashboard.php");
        }
        elseif($row['Account_Type'] == "student"){
            header("location:studentdashboard.php");
        }
    }
}

$otpNum = $_SESSION['otpSession'];
$studEmail = $_SESSION['studentEmail'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="otpdesign.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/Layout/logo1.png"/>
    <title>Sign Up</title>
</head>
<body>
    <div class="header">
        <div class="row">
            <div class="col-sm-12"></div>
        </div>
    </div>
    <div class="form">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="containerss">
                <div class="left-side">
                    <h5 id="form_label">SIGN UP</h5>
                    <div class="signup">
                    <form action = "send.php" method="POST">
                        <div class="otp-container">
                        <img src="IMAGES/signup/mail.png">
                        <br>
                        <label for="firstname">We have sent you a <strong>ONE TIME PASSWORD (OTP)</strong> on the email <strong><?php echo "$studEmail"; ?></strong></label>
                        <br>
                        <div class="otp">
                            <input type="number" id="otp_digit_1" name="otp_digit_1" value="" min="0" max="9" required oninput="limitter(this, 2); this.value.length == 1 && document.getElementById('otp_digit_2').focus();">
                            <input type="number" id="otp_digit_2" name="otp_digit_2" value="" required oninput="limitter(this, 3); this.value.length == 1 && document.getElementById('otp_digit_3').focus();">
                            <input type="number" id="otp_digit_3" name="otp_digit_3" value="" required oninput="limitter(this, 4); this.value.length == 1 && document.getElementById('otp_digit_4').focus();">
                            <input type="number" id="otp_digit_4" name="otp_digit_4" value="" required oninput="limitter(this, 4);">
                        </div>
                        </div>
                        <div class="row">                          
                            <div class="col-sm-12" id="submit-button">
                            <button type="submit" id='submit-btn' name="otpsend">Submit</button>
                            <p class='otpsend'>Didn't Receive the OTP? <button type='button' onclick='document.getElementById("otp-resend").submit()'>Resend Again</button></p>
                            </div>
                        </div>
                        <br>
                    </form>
                    <form hidden method='POST' id='otp-resend' action='send.php'><input type='text' name='send2' value='a' hidden><button type='submit'>Resend Again</button></form>
                    </div>
                </div>
                <div class="right-side">
                    <img src="IMAGES/signup/campus1.png">
                </div>
            </div>
</div>
            <div class="col-sm-3"></div>
        </div>
    </div>

    <div class="header">
        <div class="row">
            <div class="col-sm-12"></div>
        </div>
    </div>
</body>
<script>
    let otp1 = document.getElementById("otp_digit_1");

    function limitter(otp, num){
        if(otp.value.length == 1){
            document.getElementById('otp_digit_' + num).focus();
        }
        if(otp.value.length > 1){
            otp.value = otp.value.slice(-1);
        }
        if(num == 4){
            document.getElementById("submit-btn").focus();
        }
    }
</script>
</html>