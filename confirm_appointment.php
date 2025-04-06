<?php
session_start();
include('db.php');

// Check if doctor is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Check if appointment ID is provided
if (!isset($_GET['id'])) {
    header("Location: DoctorPage.php");
    exit();
}

$appointment_id = $_GET['id'];

// Update appointment status to Confirmed
$stmt = $conn->prepare("UPDATE appointment SET status = 'Confirmed' WHERE id = ?");
$stmt->bind_param("i", $appointment_id);
$stmt->execute();

header("Location: DoctorPage.php");
exit();
?>