<?php session_start(); ?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Glamour Beauty</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="main.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.cdnfonts.com/css/elegant-2" rel="stylesheet">
        <style>
            @import url('https://fonts.cdnfonts.com/css/elegant-2');
        </style>
    </head>
    <body class="homepage is-preload">
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
                        <li class="current"><a href="index.php">Home</a></li>
                        <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
                            <?php if($_SESSION['role'] == 'patient'): ?>
                                <li ><a href="PatientPage.php">Patient's Page</a></li>
								<li><a href="appointmentbooking.php">Appointment Booking</a></li>
                            <?php elseif($_SESSION['role'] == 'doctor'): ?>
                                <li ><a href="DoctorPage.php">Doctor's Page</a></li>
                                <li><a href="medication.php">Medications</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                    <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
                        <a href="logout.php" class="button">Sign Out</a>
                    <?php endif; ?>
                </nav>

       <!-- Banner -->
<section id="banner">
    <div class="content">
        <h2 style="color: #c1c2ca; font-family: 'ELEGANT', sans-serif">health .. wellness .. Lifestyle ..</h2>
        <p style="font-family: 'ELEGANT', sans-serif;">TAKE TIME FOR YOURSELF,<br> YOU DESERVE IT!</p>
        <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
            <!-- No sign out button here anymore -->
        <?php else: ?>
            <div class="role-buttons">
                <button onclick="location.href='login.php'">Log In</button>
                <button onclick="location.href='signup.php'">Sign Up</button>
            </div>
        <?php endif; ?>
    </div>

</section>


            <!-- Main Section -->
            <section id="main">
                <div class="container">
                    <div class="row gtr-200">
                        <div class="col-12">
                            <section class="box highlight">
                                <ul class="special">
                                    <li><a href="#services" class="icon solid fa-tooth"><span class="label">Dental</span></a></li>
                                    <li><a href="#services" class="icon solid fa-smile"><span class="label">Skin</span></a></li>
                                    <li><a href="#services" class="icon solid fa-lightbulb"><span class="label">Laser</span></a></li>
                                    <li><a href="#services" class="icon solid fa-heart"><span class="label">Beauty</span></a></li>
                                </ul>
                                <header>
                                    <h2 id="services">Explore Our Specialized Services</h2>
                                    <p>Providing the best care for your beauty and health needs</p>
                                </header>
                                <p>
                                    Discover top-quality services in dental care, skincare, laser treatments, and beauty enhancement. Your satisfaction is our priority.
                                </p>
                            </section>
                        </div>
                        <div class="col-12">
                            <section class="box features">
                                <h2 class="major"><span>Our Services</span></h2>
                                <div>
                                    <div class="row">
                                        <!-- Add your service boxes here -->
                                    </div>
                                </div>
                            </section>
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
                                    We offer specialized care in <strong>Dental Services</strong>, <strong>Skincare</strong>, 
                                    <strong>Laser Treatments</strong>, and <strong>Cosmetic Enhancements</strong>. 
                                    Our expert team is dedicated to helping you achieve your beauty goals with advanced techniques and personalized care. 
                                    Discover how we can bring out the best version of you today!
                                </p>
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

                    <!-- Copyright -->
                    <div id="copyright">
                        <ul class="menu">
                            <li>&copy; Glamour Beauty. All rights reserved.</li> 
                        </ul>
                    </div>
                </div>
            </footer>

        </div>

    </body>

</html>
