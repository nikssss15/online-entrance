<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";  // Default XAMPP MySQL username
$password = "";      // Default XAMPP MySQL password
$dbname = "pracEntranceExam";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form input
$std_number = $_POST['std_number'];
$password = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT Account_Type FROM student_accounts WHERE ReferenceNo = ? AND `password` = ?");
$stmt->bind_param("ss", $std_number, $password);

// Execute query
$stmt->execute();
$stmt->bind_result($account_type);
$stmt->fetch();

if ($account_type) {
    // Credentials are correct
    if ($account_type == "admin") {
        $_SESSION['logged'] = $_POST['std_number'];
        header("Location: dashboard.php");
    } elseif ($account_type == "student") {
        $_SESSION['logged'] = $_POST['std_number'];
        header("Location: studentdashboard.php");
    }
} else {
    // Invalid credentials
    echo "<script>alert('Your student number or password is incorrect'); window.location.href = 'index.php';</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
