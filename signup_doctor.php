<?php
session_start();
require 'db.php';
require 'uploadHelper.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $firstName      = htmlspecialchars(trim($_POST['first_name']));
    $lastName       = htmlspecialchars(trim($_POST['last_name']));
    $specialityName = htmlspecialchars(trim($_POST['speciality']));
    $email          = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password       = $_POST['password'];
    $id             = htmlspecialchars(trim($_POST['id'])); // User-entered ID

    try {
        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM Doctor WHERE emailAddress = ?");
        $stmt->bind_param("s", $email);  // Bind email parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=Email already exists");
            exit();
        }

        // Check if ID already exists (optional, depending on your DB structure)
        $stmt = $conn->prepare("SELECT * FROM Doctor WHERE id = ?");
        $stmt->bind_param("s", $id);  // Bind ID parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=ID already exists");
            exit();
        }

        // Upload image
        $uniqueFileName = uploadDoctorImage($_FILES['photo']);
        if (!$uniqueFileName) {
            header("Location: signup.php?error=Image upload failed");
            exit();
        }

        // Get Speciality ID
        $stmt = $conn->prepare("SELECT id FROM Speciality WHERE speciality = ?");
        $stmt->bind_param("s", $specialityName);  // Bind speciality parameter
        $stmt->execute();
        $result = $stmt->get_result();

        $speciality = $result->fetch_assoc();

        if (!$speciality) {
            header("Location: signup.php?error=Speciality not found");
            exit();
        }

        $specialityID    = $speciality['id'];
        $hashedPassword  = password_hash($password, PASSWORD_DEFAULT);

        // Insert doctor into database with user-entered ID
        $stmt = $conn->prepare("INSERT INTO Doctor (id, firstName, lastName, uniqueFileName, SpecialityID, emailAddress, password)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $id, $firstName, $lastName, $uniqueFileName, $specialityID, $email, $hashedPassword);
        $stmt->execute();

        // Set session and redirect
        $_SESSION['user_id']   = $conn->insert_id;
        $_SESSION['user_type'] = 'doctor';

        header("Location: DoctorPage.php?success=Signup successful");
        exit();

    } catch (mysqli_sql_exception $e) {
        header("Location: signup.php?error=An unexpected error occurred. Please try again.");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
