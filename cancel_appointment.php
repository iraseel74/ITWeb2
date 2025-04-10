
<?php
session_start();
include('db.php');

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$appointmentId = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM appointment WHERE id = ? AND patientId = ?");
$stmt->bind_param("ii", $appointmentId, $_SESSION['userId']);
$stmt->execute();

$_SESSION['message'] = "Appointment canceled successfully!";
header("Location: PatientPage.php");
exit();
?>
