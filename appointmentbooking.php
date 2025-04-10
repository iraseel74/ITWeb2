<?php
session_start();
include('db.php');

// Redirect if not logged in as patient
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$specialty = $_POST['specialty'] ?? '';
$doctors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['specialty'])) {
    // Load doctors with selected specialty
    $stmt = $conn->prepare("SELECT id, firstName, lastName FROM doctor WHERE specialty = ?");
    $stmt->bind_param("s", $specialty);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Handle booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctorId'], $_POST['date'], $_POST['time'], $_POST['reason'])) {
    $doctorId = $_POST['doctorId'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];
    $patientId = $_SESSION['userId'];

    $insert = $conn->prepare("INSERT INTO appointment (patientId, doctorId, date, time, reason, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $insert->bind_param("iisss", $patientId, $doctorId, $date, $time, $reason);
    $insert->execute();

    $_SESSION['message'] = "Appointment booked successfully!";
    header("Location: PatientPage.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Appointment Booking</title>
    <title>Patient Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
        <!-- Header -->
        <header id="header">
            <div class="logo container">
                <div>
                    <h1 style="color: rgba(255, 120, 185, 0.95);"><a href="index.php" id="logo">Glamour Beauty</a></h1><br>
                    <p>Your Journey to Timeless Elegance</p>
                </div>
            </div>
        </header>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <a href="index.php"><img src="images/logo1.png" alt="Logo"></a>
                <li><a href="index.php">Home</a></li>
                <li class="current"><a href="PatientPage.php">patient Page</a></li>
               
            </ul>
            <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
                        <a href="logout.php" class="button">Sign Out</a>
                    <?php endif; ?>
                        </nav>
<body>
        <!-- Main -->
        <section id="main">
            
            <div class="container">
                <div class="row">
                    <div class="col-9 col-12-medium">
                        <div class="content">
                            <article class="box page-content">
 
    <h2>Book an Appointment</h2>
    <a href="PatientPage.php">← Back to Patient Page</a><br><br>

    <!-- First form: Select specialty -->
    <form method="POST">
        <label>Select Specialty:</label>
        <select name="specialty" required>
            <option value="">-- Select --</option>
            <option value="Dermatology" <?= $specialty == "Dermatology" ? "selected" : "" ?>>Dermatology</option>
            <option value="Aesthetic Surgery" <?= $specialty == "Aesthetic Surgery" ? "selected" : "" ?>>Aesthetic Surgery</option>
            <option value="Cosmetic Dentistry" <?= $specialty == "Cosmetic Dentistry" ? "selected" : "" ?>>Cosmetic Dentistry</option>
            <option value="Plastic Surgery" <?= $specialty == "Plastic Surgery" ? "selected" : "" ?>>Plastic Surgery</option>
            <option value="Laser Treatments" <?= $specialty == "Laser Treatments" ? "selected" : "" ?>>Laser Treatments</option>
        </select>
        <button type="submit">Show Doctors</button>
    </form>

    <?php if (!empty($doctors)): ?>
        <hr>
        <form method="POST">
            <input type="hidden" name="specialty" value="<?= htmlspecialchars($specialty) ?>">
            <label>Select Doctor:</label>
            <select name="doctorId" required>
                <option value="">-- Choose --</option>
                <?php foreach ($doctors as $doc): ?>
                    <option value="<?= $doc['id'] ?>"><?= htmlspecialchars($doc['firstName'] . ' ' . $doc['lastName']) ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Date:</label>
            <input type="date" name="date" required><br>

            <label>Time:</label>
            <input type="time" name="time" required><br>

            <label>Reason:</label>
            <textarea name="reason" required></textarea><br>

            <button type="submit">Book Appointment</button>
        </form>
    <?php endif; ?>
</body>
</html>
