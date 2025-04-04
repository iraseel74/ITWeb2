<?php 
session_start();

include('db.php');

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'patient') {
        $table = 'patient';
        $email_column = 'emailAddress'; 
    } elseif ($role == 'doctor') {
        $table = 'doctor';
        $email_column = 'emailAddress'; 
    }

    $sql = "SELECT id, $email_column, password FROM $table WHERE $email_column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['userId'] = $row['id'];
            $_SESSION['role'] = $role; 
            
            if ($role == 'patient') {
                header("Location: PatientPage.php");
            } elseif ($role == 'doctor') {
                header("Location: DoctorPage.php");
            }
            exit();
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        $error_message = "No user found with this email and role. Please check your credentials.";
    }
}

$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Log-in page</title>
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
            <a href="index.php"><img src="images/logo1.png" alt="Logo"></a>
            <ul>
                <li class="current"><a href="index.php">Home</a></li>
            </ul>
        </nav>

        <!-- Log-in Form -->
        <h2 class="Log-in">Log in to Your Account :</h2>       
        <fieldset id="login-form-container">
            <form id="login-form" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="patient">Patient</option>
                    <option value="doctor">Doctor</option>
                </select>
                <?php
            if ($error_message) {
                echo '<p style="color: red;">' . $error_message . '</p>';
            }
            ?>
                <input type="submit" value="Log in">
            </form>
        </fieldset>

        <!-- Footer -->
        <footer id="footer">
            <div class="container">
                <div class="row gtr-200">
                    <div class="col-12">
                        <section>
                            <h2 class="major"><span>About Glamour Beauty</span></h2>
                            <p>
                                Welcome to <strong>Glamour Beauty</strong>, your ultimate destination for health and beauty excellence.
                            </p>
                        </section>
                    </div>
                </div>
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
