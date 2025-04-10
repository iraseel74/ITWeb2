<?php
session_start();
include('db.php');

// Initialize variables
$specialties = [];
$selectedDoctors = [];

// Get all specialties
$specialty_sql = "SELECT * FROM speciality";
$specialty_result = $conn->query($specialty_sql);
if ($specialty_result->num_rows > 0) {
    while ($row = $specialty_result->fetch_assoc()) {
        $specialties[] = $row;
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Get doctors by specialty
    if (isset($_POST['select_specialty'])) {
        $specialty_id = $_POST['specialty'];
        $stmt = $conn->prepare("SELECT * FROM doctor WHERE SpecialityID = ?");
        $stmt->bind_param("i", $specialty_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $selectedDoctors[] = $row;
        }
        $stmt->close();
    }

    // Step 2: Book appointment
    if (isset($_POST['book_appointment'])) {
        $doctor_id = $_POST['doctor'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $reason = $_POST['reason'];
        $patient_id = $_SESSION['userId'];

        $stmt = $conn->prepare("INSERT INTO appointment (DoctorID, PatientID, date, time, reason, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iisss", $doctor_id, $patient_id, $date, $time, $reason);
        $stmt->execute();
        $stmt->close();

        header("Location: PatientPage.php?message=Appointment+Booked+Successfully");
        exit();
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Appointment Booking</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="main.css" />
</head>
<body class="is-preload">
<div id="page-wrapper">

    <!-- Header -->
    <header id="header">
        <div class="logo container">
            <div>
                <h1 style="color: rgba(255, 120, 185, 0.95);"><a href="index.php" id="logo">Glamour beauty</a></h1><br>
                <p>Your Journey to Timeless Elegance</p>
            </div>
        </div>
    </header>

    <!-- Nav -->
    <nav id="nav">
        <ul>
            <a href="index.php"><img src="images/logo1.png" alt="Logo"></a>
            <li><a href="index.php">Home</a></li>
            <li><a href="PatientPage.php">Patient's Page</a></li>
            <li class="current"><a href="appointmentbooking.php">Appointment Booking</a></li>
        </ul>
        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
            <a href="logout.php" class="button">Sign Out</a>
        <?php endif; ?>
    </nav>

    <!-- Main -->
    <section id="main">
        <div class="container">
            <div class="row">
                <div class="col-9 col-12-medium">
                    <div class="content">

                        <article class="box page-content">
                            <a href="PatientPage.php" class="button"> ← Back </a><br><br>
                            <header>
                                <h2>Schedule Your Appointment</h2>
                                <p style="font-size: larger; color:grey;">"Your health is our priority! Schedule your appointment online at your convenience. Choose a date and time that suits you, and share any health concerns below. We look forward to your visit!"</p>
                            </header>

                            <!-- Step 1: Select Specialty -->
                            <form method="POST">
                                <label for="specialty">Select Specialty:</label>
                                <select name="specialty" id="specialty" required>
                                    <option value="">-- Choose --</option>
                                    <?php foreach ($specialties as $spec): ?>
                                        <option value="<?= $spec['id'] ?>" <?= (isset($_POST['specialty']) && $_POST['specialty'] == $spec['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($spec['speciality']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <br><br>
                                <button type="submit" name="select_specialty" class="button">Next</button>
                            </form>

                            <br>

                            <!-- Step 2: Booking Form -->
                            <?php if (!empty($selectedDoctors)): ?>
                                <form method="POST">
                                    <input type="hidden" name="specialty" value="<?= $_POST['specialty'] ?>">

                                    <label for="doctor">Select Doctor:</label>
                                    <select name="doctor" id="doctor" required>
                                        <option value="">-- Choose Doctor --</option>
                                        <?php foreach ($selectedDoctors as $doc): ?>
                                            <option value="<?= $doc['id'] ?>">Dr. <?= htmlspecialchars($doc['firstName'] . ' ' . $doc['lastName']) ?></option>
                                        <?php endforeach; ?>
                                    </select><br><br>

                                    <label for="date">Date:</label>
                                    <input type="date" name="date" required><br><br>

                                    <label for="time">Time:</label>
                                    <input type="time" name="time" required><br><br>

                                    <label for="reason">Reason for Visit:</label><br>
                                    <textarea name="reason" rows="4" required></textarea><br><br>

                                    <button type="submit" name="book_appointment" class="button">Book Appointment</button>
                                </form>
                            <?php endif; ?>

                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="row gtr-200">
                <div class="col-12">
                    <section>
                        <h2 class="major"><span>About Glamour Beauty</span></h2>
                        <p>
                            Welcome to <strong>Glamour Beauty</strong>, your ultimate destination for health and beauty excellence.
                            We are proud to offer specialized care in <strong>Dental Services</strong>, <strong>Skincare</strong>,
                            <strong>Laser Treatments</strong>, and <strong>Cosmetic Enhancements</strong>.
                            Our expert team is dedicated to helping you achieve your beauty goals with advanced techniques and personalized care.
                        </p>
                    </section>
                </div>
                <div class="col-12">
                    <section>
                        <h2 class="major"><span>Get in touch</span></h2>
                        <ul class="contact">
                            <li><a class="icon brands fa-facebook-f" href="#"><span class="label">Facebook</span></a></li>
                            <li><a class="icon brands fa-twitter" href="#"><span class="label">Twitter</span></a></li>
                            <li><a class="icon brands fa-instagram" href="#"><span class="label"><img src="images/instagram.png" alt="Instagram"></span></a></li>
                            <li><a class="icon brands fa-dribbble" href="#"><span class="label">Dribbble</span></a></li>
                            <li><a class="icon brands fa-linkedin-in" href="#"><span class="label">LinkedIn</span></a></li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>

        <div id="copyright">
            <ul class="menu">
                <li>&copy; Glamour Beauty. All rights reserved</li>
            </ul>
        </div>
    </footer>

</div>
</body>
</html>
