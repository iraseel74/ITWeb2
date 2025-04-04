<?php
session_start();
require 'db.php';
require 'uploadHelper.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName      = htmlspecialchars(trim($_POST['first_name']));
    $lastName       = htmlspecialchars(trim($_POST['last_name']));
    $specialityName = htmlspecialchars(trim($_POST['speciality']));
    $email          = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));  
    $password       = $_POST['password'];
    $id             = htmlspecialchars(trim($_POST['id'])); 

    try {
        $stmt = $conn->prepare("SELECT * FROM Doctor WHERE emailAddress = ?");
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=Email already exists");
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM Doctor WHERE id = ?");
        $stmt->bind_param("s", $id);  
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: signup.php?error=ID already exists");
            exit();
        }

        $uniqueFileName = uploadDoctorImage($_FILES['photo']);
        if (!$uniqueFileName) {
            header("Location: signup.php?error=Image upload failed");
            exit();
        }

        $stmt = $conn->prepare("SELECT id FROM Speciality WHERE speciality = ?");
        $stmt->bind_param("s", $specialityName);  
        $stmt->execute();
        $result = $stmt->get_result();

        $speciality = $result->fetch_assoc();

        if (!$speciality) {
            header("Location: signup.php?error=Speciality not found");
            exit();
        }

        $specialityID    = $speciality['id'];
        $hashedPassword  = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO Doctor (id, firstName, lastName, uniqueFileName, SpecialityID, emailAddress, password)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $id, $firstName, $lastName, $uniqueFileName, $specialityID, $email, $hashedPassword);
        $stmt->execute();

        $_SESSION['user_id'] = $id;       
        $_SESSION['role'] = 'doctor'; 
        $_SESSION['isLoggedIn'] = true;

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
?>
