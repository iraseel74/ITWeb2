<?php session_start(); ?>

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
                                    <h2 style="text-align: center;">Welcome, Dr. Ahmed</h2>
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
                                        <tr>
                                            <td>02/23/2025</td>
                                            <td>11 AM</td>
                                            <td>Nora Saad</td>
                                            <td>45</td>
                                            <td>Female</td>
                                            <td>Reducing Wrinkles</td>
                                            <td><button class="button">Confirm</button></td>
                                        </tr>
                                        <tr>
                                            <td>02/23/2025</td>
                                            <td>5 PM</td>
                                            <td>Majed Ahmad</td>
                                            <td>20</td>
                                            <td>Male</td>
                                            <td>Upper Eyelid Enhancement</td>
                                            <td>Confirmed</td>
                                        </tr>
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
                                        <tr>
                                            <td>Leena Naser</td>
                                            <td>40</td>
                                            <td>Female</td>
                                            <td>Botox</td>
                                            <td><a href="medication.php">Prescribe</a></td>
                                        </tr>
                                        <tr>
                                            <td>Majed Saleh</td>
                                            <td>35</td>
                                            <td>Male</td>
                                            <td>Hyaluronic Acid</td>
                                            <td><a href="medication.php">Prescribe</a></td>
                                        </tr>
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
                                                <li>Dr. Ahmed Alluhaib</li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">ID:</a></h3>
                                            <ul class="meta">
                                                <li>1124294125</li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">Birthdate:</a></h3>
                                            <ul class="meta">
                                                <li>11/6/1980</li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">Specialization:</a></h3>
                                            <ul class="meta">
                                                <li>Facial and Body Surgery Specialist</li>
                                            </ul>
                                        </article>
                                    </li>
                                    <li>
                                        <article class="box post-summary">
                                            <h3><a href="#">Email:</a></h3>
                                            <ul class="meta">
                                                <li>ahmed@gmail.com</li>
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