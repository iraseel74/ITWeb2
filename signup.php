<!DOCTYPE HTML>
<html>
	<head>
		<title>Sign-up page</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="main.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	</head>
	
	<body>
	
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<div class="logo container">
						<div>
							<h1><a href="index.php" id="logo">Glamour beauty</a></h1>	
						</div>
	
					</div>
				</header>

			<!-- Nav -->
				<nav id="nav">
					<ul>
						<a href="index.php"><img src="images/logo1.png" alt="Logo"></a>
						<li class="current"><a href="index.php">Home</a></li>
					</ul>
				</nav>
				
				
				
				<div id="role-selection-container">
					<label class="Sign-Up" for="role-selection"><h2>Select your role :</h2></label> 
					<input type="radio" id="patient" name="role" value="patient" onclick="showForm()">
					<label for="patient">Patient</label>
					<input type="radio" id="doctor" name="role" value="doctor" onclick="showForm()">
					<label for="doctor">Doctor</label>
					<?php if (isset($_GET['error'])): ?>
				<div class="error-message" style="color: red; margin: 10px;">
					<?= htmlspecialchars($_GET['error']) ?>
				</div>
				<?php endif; ?>

				<?php if (isset($_GET['success'])): ?>
					<div class="success-message" style="color: green; margin: 10px;">
						<?= htmlspecialchars($_GET['success']) ?>
					</div>
				<?php endif; ?>

				</div>
				
				<div id="form-container">
				
					<!-- Patient Form -->
					<form id="patient-form" method="POST" action="signup_patient.php">
					<legend><h3>Patient Sign-Up</h3></legend>
						<label for="first_name">First Name:</label>
						<input type="text" id="first_name" name="first_name" required>

						<label for="last_name">Last Name:</label>
						<input type="text" id="last_name" name="last_name" required>

						<label for="id">ID:</label>
						<input type="text" id="id" name="id" required>

						<label for="gender">Gender:</label>
						<select id="gender" name="gender" required>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>

						<label for="dob">Date of Birth:</label>
						<input type="date" id="dob" name="dob" required>

						<label for="email">Email:</label>
						<input type="email" id="email" name="email" required>

						<label for="password">Password:</label>
						<input type="password" id="password" name="password" required>

						<input type="submit" value="Sign Up">
					</form>

					<!-- Doctor Form -->
					<form id="doctor-form" method="POST" action="signup_doctor.php" enctype="multipart/form-data">
					<legend><h3>Doctor Sign-Up</h3></legend>
						<label for="first_name">First Name:</label>
						<input type="text" id="first_name_doc" name="first_name" required>

						<label for="last_name">Last Name:</label>
						<input type="text" id="last_name_doc" name="last_name" required>

						<label for="id_doc">ID:</label>
						<input type="text" id="id_doc" name="id" required>

						<label for="photo">Photo:</label>
						<input type="file" id="photo" name="photo" accept="image/*" required>

						<label for="speciality">Speciality:</label>
						<select id="speciality" name="speciality" required>
							<option value="general">General</option>
							<option value="dentist">Dentist</option>
							<option value="dermatologist">Dermatologist</option>
						</select>

						<label for="email">Email:</label>
						<input type="email" id="email_doc" name="email" required>

						<label for="password">Password:</label>
						<input type="password" id="password_doc" name="password" required>

						<input type="submit" value="Sign Up">
					</form>

				</div>

			<script>
				function showForm() {
					var role = document.querySelector('input[name="role"]:checked');
					if (role) {
						if (role.value == "patient") {
							document.getElementById("patient-form").style.display = "block";
							document.getElementById("doctor-form").style.display = "none";
						} else if (role.value == "doctor") {
							document.getElementById("doctor-form").style.display = "block";
							document.getElementById("patient-form").style.display = "none";
						}
					} else {
						document.getElementById("patient-form").style.display = "none";
						document.getElementById("doctor-form").style.display = "none";
					}
				}

				function navigateToPatientPage(event) {
                   event.preventDefault();
                   
                   localStorage.setItem('isLoggedIn', 'true');
				    localStorage.setItem('role', 'patient');
                   window.location.href = "PatientPage.php";
                  }

                function navigateToDoctorPage(event) {
                   event.preventDefault();
                   
                  localStorage.setItem('isLoggedIn', 'true');
				  localStorage.setItem('role', 'doctor');
                  window.location.href = "DoctorPage.php";
                }
				
				function logOut() {
    
    localStorage.removeItem('isLoggedIn');
    window.location.href = "index.php"; 
}
			</script>

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
								  Discover how we can bring out the best version of you today!
								</p>
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
