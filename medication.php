<?php 
session_start();
include('db.php');

// Check if doctor is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

// Check if patient_id is provided
if (!isset($_GET['patient_id'])) {
    header("Location: DoctorPage.php");
    exit();
}

$patient_id = $_GET['patient_id'];
$appointment_id = isset($_GET['appointment_id']) ? $_GET['appointment_id'] : null;

// Get patient information
$stmt = $conn->prepare("
    SELECT id, firstName, lastName, Gender, TIMESTAMPDIFF(YEAR, DoB, CURDATE()) as age 
    FROM patient 
    WHERE id = ?
");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

if (!$patient) {
    header("Location: DoctorPage.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medications = isset($_POST['medications']) ? $_POST['medications'] : [];
    
    // Update appointment status to Done if appointment_id is provided
    if ($appointment_id) {
        $stmt = $conn->prepare("UPDATE appointment SET status = 'Done' WHERE id = ?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
    }
    
    // Insert prescriptions
    foreach ($medications as $medication_id) {
        $stmt = $conn->prepare("INSERT INTO prescription (AppointmentID, MedicationID) VALUES (?, ?)");
        $stmt->bind_param("ii", $appointment_id, $medication_id);
        $stmt->execute();
    }
    
    header("Location: DoctorPage.php");
    exit();
}

// Get all medications
$medications = [];
$stmt = $conn->prepare("SELECT id, MedicationName FROM medication");
$stmt->execute();
$result = $stmt->get_result();
$medications = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>Medications Page</title>
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            flex-grow: 1;
        }
        .form-box {
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            width: 100%;
            max-width: 800px;
        }
        h2 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"],
        input[type="number"] {
            width: 50%;
            height: 6vh;
            padding: 6px 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        input[type="checkbox"],
        input[type="radio"] {
            appearance: none; 
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 120, 185, 0.95);
            border-radius: 5px;
            outline: none;
            cursor: pointer;
            margin-right: 10px;
            vertical-align: middle;
        }
        input[type="checkbox"]:checked,
        input[type="radio"]:checked {
            background-color: rgba(255, 120, 185, 0.95);
            border: 2px solid rgba(255, 120, 185, 0.95);
        }
        input[type="radio"] {
            border-radius: 50%;
        }
        .radio-group,
        .checkbox-group {
            margin-bottom: 5px;
        }
        .radio-group label,
        .checkbox-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        button {
            width: 100%;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }
    </style>
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
                <li><a href="DoctorPage.php">Doctor Page</a></li>
                <li class="current"><a href="medication.php"> Medications</a></li>
            </ul>
            <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true): ?>
                        <a href="logout.php" class="button">Sign Out</a>
                    <?php endif; ?>
                        </nav>

        <!-- Main -->
        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="content">
                            <div class="form-container">
                                <div class="form-box">
                                    <h2 style="color: #333;">Patient's Medications</h2>
                                    <form method="POST" action="medication.php?patient_id=<?php echo $patient_id; ?><?php echo $appointment_id ? '&appointment_id='.$appointment_id : ''; ?>">
                                        <h3>Patient Information</h3>
                                        <label for="name">Patient's Name:</label>
                                        <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($patient['firstName'] . ' ' . $patient['lastName']); ?>" readonly>
                                        
                                        <label for="age">Age:</label>
                                        <input style="width: 20%;" type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" readonly>

                                        <label>Gender:</label>
                                        <div class="radio-group">
                                            <label><input type="radio" name="gender" value="male" <?php echo $patient['Gender'] == 'Male' ? 'checked' : ''; ?> disabled> Male</label>
                                            <label><input type="radio" name="gender" value="female" <?php echo $patient['Gender'] == 'Female' ? 'checked' : ''; ?> disabled> Female</label>
                                        </div>

                                        <label>Medications:</label>
                                        <div class="checkbox-group">
                                            <?php foreach ($medications as $medication): ?>
                                            <label>
                                                <input type="checkbox" name="medications[]" value="<?php echo $medication['id']; ?>">
                                                <?php echo htmlspecialchars($medication['MedicationName']); ?>
                                            </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <input type="submit" class="button" value="Submit">
                                    </form>
                                </div>
                            </div>
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
            window.location.href = "index.php";
        }
    </script>
</body>
</html>