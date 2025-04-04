<!DOCTYPE HTML>

<html>
    <head>
        <title>Appointment Booking</title>
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
                      
                        <li><a href="PatientPage.php">Patient's Page</a></li>
                        <li class="current"><a href="appointmentbooking.php">Appointment Booking</a></li>
                    </ul>
					<a href="index.php" class="button" onclick="logOut()">Sign Out</a>
                </nav>

            <!-- Main -->
            <section id="main">
                <div class="container">
                    <div class="row">
                        <div class="col-9 col-12-medium">
                            <div class="content">

                                <!-- Content -->

                                    <article class="box page-content">
                                        
                                        <a href="PatientPage.php" class="button"> ← Back </a><br><br>
                                        <header>
                                            <h2>Schedule Your Appointment</h2>
                                            <p style="font-size: larger; color:grey;">"Your health is our priority! Schedule your appointment online at your convenience. Choose a date and time that suits you, and share any health concerns below. We look forward to your visit!"</p>
                                        </header>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const specialtyForm = document.getElementById("specialtyForm");
                                                const bookingForm = document.getElementById("bookingForm");
                                                const specialtySelect = document.getElementById("specialty");
                                                const doctorSelect = document.getElementById("doctor");
                                                
                                                const doctors = {
                                                    "Dermatology": ["Dr. Smith", "Dr. Johnson"],
                                                    "Aesthetic Surgery": ["Dr. Brown", "Dr. Taylor"],
                                                    "Cosmetic Dentistry": ["Dr. Wilson", "Dr. Martinez"],
                                                    "Plastic Surgery": ["Dr. Lee", "Dr. Patel"],
                                                    "Laser Treatments": ["Dr. Walker", "Dr. Moore"]
                                                };
                                    
                                                specialtyForm.addEventListener("submit", function(event) {
                                                    event.preventDefault();
                                                    doctorSelect.innerHTML = "";
                                                    
                                                    if (specialtySelect.value in doctors) {
                                                        doctors[specialtySelect.value].forEach(function(doctor) {
                                                            let option = document.createElement("option");
                                                            option.text = doctor;
                                                            doctorSelect.add(option);
                                                        });
                                                    }
                                                });
                                    
                                                bookingForm.addEventListener("submit", function(event) {
                                                    event.preventDefault();
                                                    window.location.href = "index.php";
                                                });
                                            });
											
											
											function logOut() {
                                               localStorage.removeItem('isLoggedIn');
                                               window.location.href = "index.php";
                                            }
																						
                                        </script>
                                    
									</head>
                                    <body>
                                        <h2>Book an Appointment</h2>
                                        
                                        <!-- First Form: Select Specialty -->
                                        <form id="specialtyForm">
                                            <label for="specialty">Select Specialty:</label>
                                            <select id="specialty" name="specialty">
                                                <option value="Dermatology">Dermatology</option>
                                                <option value="Aesthetic Surgery">Aesthetic Surgery</option>
                                                <option value="Cosmetic Dentistry">Cosmetic Dentistry</option>
                                                <option value="Plastic Surgery">Plastic Surgery</option>
                                                <option value="Laser Treatments">Laser Treatments</option>
                                            </select><br>
                                            <button type="submit" class="button">Next</button>
                                        </form>
                                        
                                        <br>
                                        
                                        <!-- Second Form: Booking Details -->
                                        <form id="bookingForm">
                                            <label for="doctor">Select Doctor:</label>
                                            <select id="doctor" name="doctor">
                                                <option value="">Select a specialty first</option>
                                            </select>
                                            <br>
                                            <label for="date">Select Date:</label>
                                            <input type="date" id="date" name="date" required>
                                            <br>
                                            <label for="time">Select Time:</label>
                                            <input type="time" id="time" name="time" required>
                                            <br>
                                            <label for="reason">Reason for Visit:</label>
                                            <textarea id="reason" name="reason" required></textarea>
                                            <br>
                                            <a href="PatientPage.php" class="button">Book Appointment</a>

                                        </form><br>


</div>
</div>
<div class="col-3 col-12-medium">
    <div class="sidebar">

        <!-- Sidebar -->

</div>
</div>
</div>
</section>

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