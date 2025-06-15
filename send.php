<?php

session_start();

$server = "localhost";
$username = "root";
$password = "";
$db_name = "pracEntranceExam";

$conn = mysqli_connect($server, $username, $password, $db_name);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST["send"])) {
    $checkEmail = $_POST['email'];
    $uniqueEmail = "SELECT * FROM Student_Accounts WHERE `Email` = '$checkEmail'";
    $uniqueEmailrun = mysqli_query($conn, $uniqueEmail);

    if ($numrows = mysqli_num_rows($uniqueEmailrun) > 0) {
        $_SESSION['usedEmail'] = 1;
        header("location:signup.php");
    }

    $_SESSION['Course'] = $_POST['Course'];
    $_SESSION['fname'] = $_POST["fname"];
    $_SESSION['lname'] = $_POST["lname"];
    $_SESSION['mname'] = $_POST["mname"];
    $_SESSION['email'] = $_POST["email"];
    $_SESSION['password123'] = "Password123!";
    $_SESSION['gender'] = $_POST["gender"];
    $_SESSION['bdate'] = $_POST["bdate"];
    $_SESSION['gcontact'] = $_POST["gcontact"];
    $_SESSION['guardian'] = $_POST["guardian"];
    $_SESSION['gcontact'] = $_POST["gcontact"];
    $_SESSION['student'] = "student";
    $_SESSION['address'] = $_POST["address"];

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'innovateu.school@gmail.com'; // Admin Gmail
    $mail->Password = 'fipizipsidthqzcb'; // Admin Password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('innovateu.school@gmail.com', 'Mailer'); // Admin Gmail

    $mail->addAddress('innovateu.school@gmail.com', 'NameHere');

    $mail->isHTML(true);

    $mail->Subject = "Student Verification";

    $mail->Body = '
    <h2>Student Information</h2>
    <ul>
        <li><strong>Name:</strong></li>
        <ul>
            <li>First Name: ' . $_POST["fname"] . ' </li>
            <li>Middle Name: ' . $_POST["lname"] . ' </li>
            <li>Last Name: ' . $_POST["mname"] . ' </li>
        </ul>
        <li><strong>Date of Birth:</strong> ' . $_POST["bdate"] . ' </li>
        <li><strong>Gender:</strong> ' . $_POST["gender"] . ' </li>
        <li><strong>Contact Information:</strong></li>
        <ul>
            <li>Phone: ' . $_POST["contact"] . ' </li>
            <li>Email: ' . $_POST["email"] . ' </li>
            <li>Address: ' . $_POST["address"] . ' </li>
        </ul>
        <li><strong>Course:</strong> ' . $_POST["Course"] . ' </li>
        <li><strong>Guardian Information:</strong></li>
        <ul>
            <li>Name: ' . $_POST["guardian"] . ' </li>
            <li>Contact: ' . $_POST["gcontact"] . ' </li>
        </ul>
    </ul>
    ';
    $mail->send();

    //end of first email

    //otp generator

    $otpSend = rand(1000, 9999);

    $_SESSION['otpSession'] = $otpSend;

    $studEmail = $_POST['email'];

    $_SESSION['studentEmail'] = $studEmail;

    //start of first email

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'innovateu.school@gmail.com'; // Admin Gmail
    $mail->Password = 'wxxrnbjzfqogiqro'; // Admin Password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('innovateu.school@gmail.com', 'Mailer'); // Admin Gmail

    $mail->addAddress($studEmail, 'NameHere');

    $mail->isHTML(true);

    $mail->Subject = "Student Verification";

    $mail->Body = '
    <h2>OTP Verification</h2>
    <p>Dear Student, </p>
    <p>Please use the following One Time Password (OTP) to complete your registration.</p>
    <ul>
        <li>Your OTP Number: ' . $otpSend . ' </li>
    </ul>
    <p>Thank you, </p>
    <p>InnovateU Technological Institution</p>
    ';
    $mail->send();
    echo
    "
            <script>
            document.location.href = 'otp.php';
            </script>
            ";
}

if (isset($_POST["send2"])) {
    //otp generator

    $otpSend = $_SESSION['otpSession'];

    $studEmail = $_SESSION['studentEmail'];

    //start of first email

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'innovateu.school@gmail.com'; // Admin Gmail
    $mail->Password = 'wxxrnbjzfqogiqro'; // Admin Password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('innovateu.school@gmail.com', 'Mailer'); // Admin Gmail

    $mail->addAddress($studEmail, 'NameHere');

    $mail->isHTML(true);

    $mail->Subject = "Student Verification";

    $mail->Body = '
    <h2>OTP Verification</h2>
    <p>Dear Student, </p>
    <p>Please use the following One Time Password (OTP) to complete your registration.</p>
    <ul>
        <li>Your OTP Number: ' . $otpSend . ' </li>
    </ul>
    <p>Thank you, </p>
    <p>InnovateU Technological Institution</p>
    ';
    $mail->send();
    echo
    "
            <script>
            document.location.href = 'otp.php';
            </script>
            ";
}


if (isset($_POST['otpsend'])) {
    $otpOverall = $_POST['otp_digit_1'] . $_POST['otp_digit_2'] . $_POST['otp_digit_3'] . $_POST['otp_digit_4'];
    if ($otpOverall == $_SESSION['otpSession']) {
        $courses = $_SESSION['Course'];
        $fname = $_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $mname = $_SESSION['mname'];
        $studemail = $_SESSION['email'];
        $passwords = "Password123!";
        $gender = $_SESSION['gender'];
        $bday = $_SESSION['bdate'];
        $contact = $_SESSION['gcontact'];
        $guardian = $_SESSION['guardian'];
        $guardiancontact = $_SESSION['gcontact'];
        $acc_type = "student";
        $address = $_SESSION['address'];
        $getCourseID = "SELECT Course_ID FROM courses WHERE CourseName = '$courses'";
        $getCourseIDrun = mysqli_query($conn, $getCourseID);
        $getCourseIDrow = mysqli_fetch_assoc($getCourseIDrun);
        $CourseID = $getCourseIDrow['Course_ID'];

        $createAcc = "INSERT INTO `student_accounts`(`Course_ID`, `FirstName`, `LastName`, `MiddleName`, `Email`, `Password`, `Gender`, `Birthdate`, `Contact`, `Guardian`, `GuardianContact`, `Account_Type`, `Address`) VALUES('$CourseID', '$fname', '$lname', '$mname', '$studemail', '$passwords', '$gender', '$bday', '$contact', '$guardian', '$guardiancontact', '$acc_type', '$address')";
        $createAccrun = mysqli_query($conn, $createAcc);

        $selectEmail = "SELECT ReferenceNo FROM student_accounts WHERE `Email` = '$studemail'";
        $selectEmailrun = mysqli_query($conn, $selectEmail);
        $selectEmailrow = mysqli_fetch_assoc($selectEmailrun);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'innovateu.school@gmail.com'; // Admin Gmail
        $mail->Password = 'wxxrnbjzfqogiqro'; // Admin Password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('innovateu.school@gmail.com', 'Mailer'); // Admin Gmail

        $mail->addAddress($studemail, 'NameHere');

        $mail->isHTML(true);

        $mail->Subject = "Student Verification";

        $mail->Body = '
            <h2>Student Information</h2>
            <p>Hello ' . $fname . ' ' . $lname  . ',</p>
            <p>Below you can find your Control Number and Temporary Password in order to access your Student Portal.</p>
            <ul>
                <li><strong>Control Number</strong>: ' . $selectEmailrow['ReferenceNo'] . ' </li>
                <li><strong>Temporary Password</strong>: Password123! </li>
            </ul>
            <p>Be sure to change your Temporary Password in your profile after logging in.</p>
            <p>Thank you, </p>
            ';
        $mail->send();

        echo
        "
            <script>
            alert('Sent Sucessfully. You will be receiving an email from us container your Control Number and Temporary Password.');
            document.location.href = 'index.php';
            </script>
            ";

        session_destroy();
    } else {
        echo
        "
            <script>
            alert('Not Sent Sucessfully');
            document.location.href = 'otp.php';
            </script>
            ";
    }
}
