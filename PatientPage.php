<?php
session_start();
include('db.php');

// Ensure the user is logged in and is a patient
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['userId'];

// Fetch patient info safely
$user_sql = "SELECT * FROM `patient` WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo "<p style='color:red;'>Error: Patient not found.</p>";
    exit();
}

// Fetch appointments safely
$app_sql = "SELECT a.*, d.firstName, d.lastName, d.uniqueFileName AS doctorPhoto, 
            DATE_FORMAT(a.time, '%h:%i %p') AS formattedTime 
            FROM appointment a 
            LEFT JOIN doctor d ON a.DoctorID = d.id 
            WHERE a.PatientID = ? AND a.status != 'Done' 
            ORDER BY a.date ASC, a.time ASC";

$app_stmt = $conn->prepare($app_sql);
$app_stmt->bind_param("i", $user_id);
$app_stmt->execute();
$app_result = $app_stmt->get_result();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Patient Page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <li class="current"><a href="PatientPage.php">Patient's Page</a></li>
            <li><a href="appointmentbooking.php">Appointment Booking</a></li>
        </ul>
        <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
            <a href="logout.php" class="button">Sign Out</a>
        <?php endif; ?>
    </nav>

    <!-- Main -->
    <section id="main">
        <div class="container">
            <div class="row">

                <!-- Main Content -->
                <div class="col-9 col-12-medium">
                    <div class="content">
                        <article class="box page-content">
                            <header>
                            <p>Welcome, <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></p>
                            </header>

                            <a href="appointmentbooking.php" class="button">Request a new appointment</a><br><br>


                            <h3>Upcoming Appointments</h3>

<?php if ($app_result->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($appointment = $app_result->fetch_assoc()): ?>
                <tr>
                    <td>Dr. <?php echo htmlspecialchars($appointment['firstName'] . ' ' . $appointment['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['formattedTime']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No upcoming appointments.</p>
<?php endif; ?>

                        </article>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-3 col-12-medium">
                    <div class="sidebar">
                        <section>
                            <ul class="divided">
                                <br><br>
                                <li>
                                    <article class="box post-summary">
                                        <h3><a href="#">Name:</a></h3>
                                        <ul class="meta"><li><?= htmlspecialchars($user['firstName']) . ' ' . htmlspecialchars($user['lastName']); ?></li></ul>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-summary">
                                        <h3><a href="#">ID:</a></h3>
                                        <ul class="meta"><li><?= htmlspecialchars($user['id']); ?></li></ul>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-summary">
                                        <h3><a href="#">Gender:</a></h3>
                                        <ul class="meta"><li><?= htmlspecialchars($user['Gender']); ?></li></ul>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-summary">
                                        <h3><a href="#">Birthdate:</a></h3>
                                        <ul class="meta"><li><?= htmlspecialchars($user['DoB']); ?></li></ul>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-summary">
                                        <h3><a href="#">Email:</a></h3>
                                        <ul class="meta"><li><?= htmlspecialchars($user['emailAddress']); ?></li></ul>
                                    </article>
                                </li>
                            </ul>
                        </section>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<!-- Footer -->
<footer id="footer">
<div class="container">
<div class="row gtr-200">
<div class="col-12">

    <!-- About -->
        <section>
            <section>
                <h2 class="major"><span>About Glamour Beauty</span></h2>
                <p>
                  Welcome to <strong>Glamour Beauty</strong>, your ultimate destination for health and beauty excellence. 
                  We are proud to offer specialized care in <strong>Dental Services</strong>, <strong>Skincare</strong>, 
                  <strong>Laser Treatments</strong>, and <strong>Cosmetic Enhancements</strong>. 
                  Our expert team is dedicated to helping you achieve your beauty goals with advanced techniques and personalized care. 
                  Discover how we can bring out the best version of you today!
                </p>
          </section>

</div>
<div class="col-12">

    <!-- Contact -->
        <section>
            <h2 class="major"><span>Get in touch</span></h2>
            <ul class="contact">
                <li><a class="icon brands fa-facebook-f" href="#"><span class="label">Facebook</span></a></li>
                <li><a class="icon brands fa-twitter" href="#"><span class="label">Twitter</span></a></li>
                <li><a class="icon brands fa-instagram" href="#"><span class="label"><img src="images/instagram.png"></span></a></li>
                <li><a class="icon brands fa-dribbble" href="#"><span class="label">Dribbble</span></a></li>
                <li><a class="icon brands fa-linkedin-in" href="#"><span class="label">LinkedIn</span></a></li>
            </ul>
        </section>

</div>
</div>

</div>

                        <!-- Copyright -->
                        <div id="copyright">
                            <ul class="menu">
                                <li>&copy; Glamour Beauty.. All rights reserved</li> 
                            </ul>
                        </div>
</footer>

</div>
</body>
</html>
