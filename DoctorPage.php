<?php 
session_start();
include('db.php');


// Check if doctor is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}



// Get doctor's information
$doctor_id = $_SESSION['userId'];
$doctor_info = [];
$upcoming_appointments = [];
$patients = [];

// Fetch doctor details
$stmt = $conn->prepare("
    SELECT d.firstName, d.lastName, d.emailAddress, s.speciality 
    FROM doctor d 
    JOIN speciality s ON d.SpecialityID = s.id 
    WHERE d.id = ?
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor_info = $result->fetch_assoc();

// Fetch upcoming appointments (Pending or Confirmed)
$stmt = $conn->prepare("
    SELECT a.id, a.date, a.time, p.firstName, p.lastName, 
           TIMESTAMPDIFF(YEAR, p.DoB, CURDATE()) as age, 
           p.Gender, a.reason, a.status 
    FROM appointment a 
    JOIN patient p ON a.PatientID = p.id 
    WHERE a.DoctorID = ? AND a.status IN ('Pending', 'Confirmed')
    ORDER BY a.date, a.time
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$upcoming_appointments = $result->fetch_all(MYSQLI_ASSOC);

// Fetch doctor's patients (those with Done appointments)
$stmt = $conn->prepare("
    SELECT DISTINCT p.id, p.firstName, p.lastName, 
           TIMESTAMPDIFF(YEAR, p.DoB, CURDATE()) as age, 
           p.Gender, GROUP_CONCAT(m.MedicationName SEPARATOR ', ') as medications
    FROM appointment a 
    JOIN patient p ON a.PatientID = p.id 
    LEFT JOIN prescription pr ON a.id = pr.AppointmentID
    LEFT JOIN medication m ON pr.MedicationID = m.id
    WHERE a.DoctorID = ? AND a.status = 'Done'
    GROUP BY p.id
    ORDER BY p.firstName, p.lastName
");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$patients = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>Doctor Page</title>
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="is-preload">
    <div id="page-wrapper">

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
                <li class="current"><a href="DoctorPage.php">Doctor Page</a></li>
                <li><a href="medication.php">Medications</a></li>
            </ul>
            <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
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
                                <header>
                                    <h2 style="text-align: center;">Welcome, Dr. <?php echo htmlspecialchars($doctor_info['firstName']); ?></h2>
                                </header>

                                <br><br><br><br>
                                <h2 style="color: rgba(255, 120, 185, 0.95)">Upcoming Appointments</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Patient's Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Reason for Visit</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($upcoming_appointments as $appointment): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['firstName']) . ' ' . htmlspecialchars($appointment['lastName']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['age']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['Gender']); ?></td>
                                            <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                                            <td>
                                                <?php if ($appointment['status'] == 'Pending'): ?>
                                                    <a href="confirm_appointment.php?id=<?php echo $appointment['id']; ?>" class="button">Confirm</a>
                                                <?php elseif ($appointment['status'] == 'Confirmed'): ?>
                                                    <a href="medication.php?patient_id=<?php echo $appointment['PatientID']; ?>&appointment_id=<?php echo $appointment['id']; ?>">Prescribe</a>
                                                <?php else: ?>
                                                    <?php echo htmlspecialchars($appointment['status']); ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <br>
                                <h2 style="color: rgba(255, 120, 185, 0.95)">Your Patients</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Patient's Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Medications</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($patients as $patient): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($patient['firstName']) . ' ' . htmlspecialchars($patient['lastName']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['age']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['Gender']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['medications'] ?: 'None'); ?></td>
                                            <td><a href="medication.php?patient_id=<?php echo $patient['id']; ?>">Prescribe</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </article>
                        </div>
                    </div>
                    <div class="col-3 col-12-medium">
                        <div class="sidebar">
                            <!-- Sidebar -->
                            <section>
                                <ul class="divided">
                                    <li>
                                        <article class="box post-summary">
                                            <img src="images/DoctorPhoto.png" alt="Doctor Photo" width="310" height="220"/>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">Name:</a></h3>
                                            <ul class="meta">
                                                <li>Dr. <?php echo htmlspecialchars($doctor_info['firstName'] ). ' ' . htmlspecialchars($doctor_info['lastName']); ?></li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">ID:</a></h3>
                                            <ul class="meta">
                                                <li><?php echo htmlspecialchars($doctor_id); ?></li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">Specialization:</a></h3>
                                            <ul class="meta">
                                                <li><?php echo htmlspecialchars($doctor_info['speciality']); ?></li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">Email:</a></h3>
                                            <ul class="meta">
                                                <li><?php echo htmlspecialchars($doctor_info['emailAddress']); ?></li>
                                            </ul>
                                        </article>
                                    </li>
                                </ul>
                            </section>
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
                            <p>Welcome to <strong>Glamour Beauty</strong>, your ultimate destination for health and beauty excellence. 
                            We are proud to offer specialized care in <strong>Dental Services</strong>, <strong>Skincare</strong>, 
                            <strong>Laser Treatments</strong>, and <strong>Cosmetic Enhancements</strong>. 
                            Our expert team is dedicated to helping you achieve your beauty goals with advanced techniques and personalized care. 
                            Discover how we can bring out the best version of you today!</p>
                        </section>
                    </div>
                    <div class="col-12">
                        <section>
                            <h2 class="major"><span>Get in Touch</span></h2>
                            <ul class="contact">
                                <li><a class="icon brands fa-facebook-f" href="#"><span class="label">Facebook</span></a></li>
                                <li><a class="icon brands fa-twitter" href="#"><span class="label">Twitter</span></a></li>
                                <li><a class="icon brands fa-instagram" href="#"><span class="label">Instagram</span></a></li>
                                <li><a class="icon brands fa-dribbble" href="#"><span class="label">Dribbble</span></a></li>
                                <li><a class="icon brands fa-linkedin-in" href="#"><span class="label">LinkedIn</span></a></li>
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
            <div id="copyright">
                <ul class="menu">
                    <li>&copy; Glamour Beauty. All rights reserved.</li>
                </ul>
            </div>
        </footer>
    </div>

    <script>
        function logOut() {
            localStorage.removeItem('isLoggedIn');
            window.location.href = "index.html";
        }
    </script>
</body>
</html>