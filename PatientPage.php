<?php session_start(); ?>

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
                        <div class="col-9 col-12-medium">
                            <div class="content">

                                <!-- Content -->

                                    <article class="box page-content">

                                        <header>
                                            <h2>Welcome, Noha</h2>
                                        </header>

            
<a href="appointmentbooking.php" class="button">Request a new appointment</a> <br>  <br>                            
<h2>Upcoming Appointments</h2>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Doctor's Name</th>
            <th>Doctor's Photo</th>
            <th>Status</th>
            <th>Actions</th> <!-- Added Actions column -->
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; vertical-align: middle;">02/23/2025</td>
            <td style="text-align: center; vertical-align: middle;">11 AM</td>
            <td style="text-align: center; vertical-align: middle;">Nora Saad</td>
            <td style="text-align: center; vertical-align: middle;"><img src="images/nora.jpg" alt="" width="270" height="150"/></td>
            <td style="text-align: center; vertical-align: middle;" class="status">Pending</td>
            <td style="text-align: center; vertical-align: middle;">
                <button class="button">Cancel</button>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: middle;">02/23/2025</td>
            <td style="text-align: center; vertical-align: middle;">5 PM</td>
            <td style="text-align: center; vertical-align: middle;">Majed Ahmad</td>
            <td style="text-align: center; vertical-align: middle;"><img src="images/majed.jpg" alt="" width="270" height="150"/></td>
            <td style="text-align: center; vertical-align: middle;" class="status">Confirmed</td>
            <td style="text-align: center; vertical-align: middle;">
                <button class="button">Cancel</button>
            </td>
        </tr>
    </tbody>
</table>
<br>
										
										

</div>
</div>
<div class="col-3 col-12-medium">
    <div class="sidebar">

        <!-- Sidebar -->

            <!-- Recent Posts -->
                                        <!-- Recent Posts -->
                                        <section>
                                            <!--  <h2 class="major"><span></span></h2>-->
                                              <ul class="divided">
                                                  <br>
                                                  <br>
                                                  <li>
                                                      <article class="box post-summary">
                                                          <h3><a href="#">Name:</a></h3>
                                                          <ul class="meta">
                                                              <li >Noha Alrasheed</li>
                                                          </ul>
                                                      </article>
                                                  </li>
                                                  <li>
                                                      <article class="box post-summary">
                                                          <h3><a href="#">ID:</a></h3>
                                                          <ul class="meta">
                                                              <li >Noha1192</li>
                                                          </ul>
                                                      </article>
                                                  </li>
                                                  <li>
                                                      <article class="box post-summary">
                                                          <h3><a href="#">Gender:</a></h3>
                                                          <ul class="meta">
                                                              <li >Female</li>
                                                          </ul>
                                                      </article>
                                                  </li>
                                                  <li>
                                                      <article class="box post-summary">
                                                          <h3><a href="#">Birthdate:</a></h3>
                                                          <ul class="meta">
                                                              <li >2003/07/01</li>
                                                      
                                                          </ul>
                                                      </article>
                                                  </li>
                                                  <li>
                                                      <article class="box post-summary">
                                                          <h3><a href="#">Email:</a></h3>
                                                          <ul class="meta">
                                                              <li >Nohaaalrasheed@gmail.com</li>
                                                      
                                                          </ul>
                                                      </article>
                                                  </li>
                                                  <li></li>
                                              </ul>
                                          
                                          </section>


                              </div>
                          </div>
                          <div class="col-12">
    <!-- Features -->
        <section class="box features">
            <h2 class="major"><span>Feature of Glamour beauty clinic</span></h2>
            <div>
                <div class="row">
                    <div class="col-3 col-6-medium col-12-small">

                        <!-- Feature -->
                            <section class="box feature">
                                <a href="#" class="image featured"><img src="images/doc.AVIF" alt="" width=190px height="140px" /></a>
                                <h3><a href="#">Our Expert Team</a></h3>
                                <p>
              If you're looking for beauty treatments with over 30 years of experience,
               our skilled professionals are here to enhance your natural beauty.
                We specialize in a variety of aesthetic procedures tailored to meet your individual needs.
                                </p>
                            </section>

                    </div>
                    <div class="col-3 col-6-medium col-12-small">

                        <!-- Feature -->
                            <section class="box feature">
                                <a href="#" class="image featured"><img src="images/bot.JPG" alt="" width=190px height="140px" /></a>
                                <h3><a href="#">Advanced Techniques </a></h3>
                                <p>
                                    We always strive to offer the best ways to deliver exceptional services.
                                     Our team stays updated with the latest advancements in the beauty industry 
                                     to ensure you receive the highest quality treatments.
                                </p>
                            </section>

                    </div>
                    <div class="col-3 col-6-medium col-12-small">

                        <!-- Feature -->
                            <section class="box feature">
                                <a href="#" class="image featured"><img src="images/tecc.WEBP" alt="" width=190px height="140px"/></a>
                                <h3><a href="#">Treatment Methodology</a></h3>
                                <p> 
                             We provide comprehensive beauty services, including an initial consultation, 
                            customized treatment plans, and ongoing support to ensure client satisfaction.
                                </p>
                            </section>

                    </div>
                    <div class="col-3 col-6-medium col-12-small">

                        <!-- Feature -->
                            <section class="box feature">
                                <a href="#" class="image featured"><img src="images/smaile.JPG" alt="" width=190px height="140px" /></a>
                                <h3><a href="#">Patient Comfort</a></h3>
                                <p>
                                    Visiting our beauty clinic is more than just a treatment;
                                     it’s a chance to indulge in self-care. We believe in making every visit a unique experience, 
                                     dedicated to your satisfaction and well-being.
                                </p>
                            </section>

                    </div>
                   <!-- <div class="">
                        <ul class="">
                            <li><a href="#" class=""></a></li>
                            <li><a href="#" class=""></a></li>
                        </ul> 
                    </div> -->
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

<script>
function logOut() {
    localStorage.removeItem('isLoggedIn');
    window.location.href = "index.php";
}
</script>
</html>