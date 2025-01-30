<?php
session_start();
require_once 'db_connection.php';

// Procesi i regjistrimit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role_id = $_POST['role'];
    
    if ($password !== $cpassword) {
        $_SESSION['register_error'] = "Passwords do not match!";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Kontrollo nëse emaili ekziston
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['register_error'] = "This email is already registered.";
        } else {
            // Regjistro përdoruesin
            $sql = "INSERT INTO users (emri, mbiemri, email, password, role_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $emri, $mbiemri, $email, $password, $role_id);
            
            try {
                if ($stmt->execute()) {
                    $_SESSION['success'] = "Registration successful! Please log in.";
                    header("Location: login.html");
                    exit();
                }
            } catch (mysqli_sql_exception $e) {
                $_SESSION['register_error'] = "An error occurred during registration. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Singup page</title>
    <link rel="stylesheet" href="singupstyle.css">
    <!-- Shto Font Awesome për ikonat -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="nav">
        <div class="nav-logo">
            <a href="index.php"><img src="./fotot/logo.png" alt="Logo" /></a> 
        </div>
    </div>
    <div class="container">
        <div class="info-section">
            <h1>Search better with an account</h1>
            <div class="feature">
                <img src="fotot/singupicon1.PNG" alt="Save listings icon" class="icon">
                <div>
                    <h3>Save listings you love</h3>
                    <p>Keep an eye on your favorite homes.</p>
                </div>
            </div>
            <div class="feature">
                <img src="fotot/singupicon2.PNG" alt="Save searches icon" class="icon">
                <div>
                    <h3>Save your searches</h3>
                    <p>Get alerts for homes that are perfect for you.</p>
                </div>
            </div>
            <div class="feature">
                <img src="fotot/singupicon3.PNG" alt="Search from anywhere icon" class="icon">
                <div>
                    <h3>Search from anywhere</h3>
                    <p>Access your search across all your devices.</p>
                </div>
            </div>
            <div class="real-estate-link">
                <p>Are you a real estate professional? <a href="login.html">Log in here</a></p>
            </div>
        </div>
        <div class="signup-section">
            <h2>Sign up</h2>
            
            <?php if (isset($_SESSION['register_error'])): ?>
                <div class="alert alert-error">
                    <?php 
                        echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']);
                    ?>
                </div>
            <?php endif; ?>
           
            <form method="POST">
                <div class="input-group">
                    <input type="text" name="emri" placeholder="Emri*" required>
                </div>
                <div class="input-group">
                    <input type="text" name="mbiemri" placeholder="Mbiemri*" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email address*" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Create password*" required>
                    <span id="togglePassword" class="password-toggle">👁</span>
                </div>
                <div class="input-group">
                    <input type="password" name="cpassword" id="cpassword" placeholder="Confirm password*" required>
                    <span id="ctogglePassword" class="cpassword-toggle">👁</span>
                </div>
                <div class="input-group">
                    <label for="role">Choose role:</label>
                    <select name="role" id="role">
                        <option value="1">USER</option>
                        <option value="2">ADMIN</option>
                    </select>
                </div>
                <button type="submit" class="signup-btn">Sign up</button>
            </form>
            <p class="login-link">Already have an account? <a href="login.html">Log in</a></p>
            <div class="divider">
                <span>OR</span>
            </div>

            <div class="social-buttons">
                <button class="social-btn google">
                    <img src="fotot/googlelogo.png" alt="Google Logo"> Continue with Google
                </button>
                <button class="social-btn facebook">
                    <img src="fotot/facebooklogo.png" alt="Facebook Logo"> Continue with Facebook
                </button>
                <button class="social-btn apple">
                    <img src="fotot/appleologo.png" alt="Apple Logo"> Continue with Apple
                </button>
            </div>
        </div>
    </div>
    <script src="singupscript.js"></script>
</body>
</html> 