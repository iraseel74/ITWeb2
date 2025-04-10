<?php
session_start();
include('db.php');

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$patientId = $_SESSION['userId'];

// Get patient info
$stmt = $conn->prepare("SELECT firstName, lastName, emailAddress FROM patient WHERE id = ?");
$stmt->bind_param("i", $patientId);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

// Get appointments
$app_stmt = $conn->prepare("
    SELECT a.id, a.date, a.time, a.status, d.firstName AS doctorFirstName, d.lastName AS doctorLastName  
    FROM appointment a
    JOIN doctor d ON a.doctorId = d.id
    WHERE a.patientId = ?
    ORDER BY a.date, a.time
");
$app_stmt->bind_param("i", $patientId);
$app_stmt->execute();
$app_result = $app_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
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
                                <header>
                                    <h1>Welcome, <?= htmlspecialchars($patient['firstName'] . ' ' . $patient['lastName']) ?></h1>
    <p>Email: <?= htmlspecialchars($patient['emailAddress']) ?></p>

                                </header>

    
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?= $_SESSION['message'] ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <a style="color: rgba(255, 120, 185, 0.95);width: 100%;
            padding: 10px;            border-radius: 15px;
" href="appointmentbooking.php">Book an Appointment</a>
    <h2>Your Appointments</h2>
    <br><br>

    <?php if ($app_result->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $app_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['time'] ?></td>
                    <td><?= htmlspecialchars($row['doctorFirstName'] . ' ' . $row['doctorLastName']) ?></td>
                    <td><img src="images/<?= $row['photo'] ?>" width="60" height="60"></td>
                    <td><?= $row['status'] ?></td>
                    <td><a href="cancel_appointment.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel</a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
</body>
</html>
