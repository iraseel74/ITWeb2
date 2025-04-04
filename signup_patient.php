<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName  = htmlspecialchars(trim($_POST['last_name']));
    $gender    = $_POST['gender'];
    $dob       = $_POST['dob'];
    $email     = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password  = $_POST['password'];
    $id        = $_POST['id'];  // Get the id from the form

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM patient WHERE emailAddress = ?");
        $stmt->bind_param("s", $email);  // "s" denotes a string parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=Email already exists");
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB (Including the 'id' field now)
        $stmt = $conn->prepare("INSERT INTO patient (id, firstName, lastName, Gender, DoB, emailAddress, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $id, $firstName, $lastName, $gender, $dob, $email, $hashedPassword);  // Bind parameters
        $stmt->execute();

        // Set session variables
        $_SESSION['user_id'] = $conn->insert_id;  // Can be used to track the user
        $_SESSION['user_type'] = 'patient';

        // Redirect to patient page
        header("Location: PatientPage.php?success=Signup successful");
        exit();

    } catch (mysqli_sql_exception $e) {
        // Handle DB error
        header("Location: signup.php?error=An unexpected error occurred. Please try again.");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
