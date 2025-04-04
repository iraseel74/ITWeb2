<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName  = htmlspecialchars(trim($_POST['last_name']));
    $gender    = $_POST['gender'];
    $dob       = $_POST['dob'];
    $email     = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)); 
    $password  = $_POST['password'];
    $id        = $_POST['id'];  

    try {
        $stmt = $conn->prepare("SELECT * FROM patient WHERE emailAddress = ?");
        $stmt->bind_param("s", $email);  
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=Email already exists");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM patient WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=ID already exists");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO patient (id, firstName, lastName, Gender, DoB, emailAddress, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $id, $firstName, $lastName, $gender, $dob, $email, $hashedPassword);  
        $stmt->execute();

        $_SESSION['user_id'] = $id;       
        $_SESSION['role'] = 'patient'; 
        $_SESSION['isLoggedIn'] = true;

        header("Location: PatientPage.php?success=Signup successful");
        exit();

    } catch (mysqli_sql_exception $e) {
        header("Location: signup.php?error=An unexpected error occurred. Please try again.");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
