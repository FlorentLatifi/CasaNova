<?php
include 'db_connection.php';
// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $roleName = $_POST['role'];  // This is the role name (like USER, ADMIN, etc.)

    // Check if password and confirm password match
    if ($password != $cpassword) {
        die("Password and confirm password do not match.");
    }

    // Check if the email already exists
    $sqlCheckEmail = "SELECT id FROM users WHERE email = ?";
    $stmtCheckEmail = $conn->prepare($sqlCheckEmail);
    $stmtCheckEmail->bind_param("s", $email);
    $stmtCheckEmail->execute();
    $resultCheckEmail = $stmtCheckEmail->get_result();

    if ($resultCheckEmail->num_rows > 0) {
        echo "<script>alert('The email address is already registered. Please use a different email or log in.'); window.location.href='register.html';</script>";
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Find role_id from roles table based on the role (e.g., USER, ADMIN)
    $sqlRole = "SELECT id FROM roles WHERE name = ?";
    $stmtRole = $conn->prepare($sqlRole);
    $stmtRole->bind_param("s", $roleName);
    $stmtRole->execute();
    $resultRole = $stmtRole->get_result();

    if ($resultRole->num_rows == 0) {
        die("The selected role does not exist.");
    }

    $role = $resultRole->fetch_assoc();
    $roleId = $role['id'];

    // Parameters for the SQL query to register the user
    $sql = "INSERT INTO users (emri, mbiemri, email, password, role_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $emri, $mbiemri, $email, $hashedPassword, $roleId); // Use $hashedPassword

    // Execute the SQL query
    if ($stmt->execute()) {
        // User registered, redirect to login page
        header("Location: login.html");
        exit(); // Ensure to stop further execution
    } else {
        die("Error during registration: " . $stmt->error);
    }
}

// Close the database connection
$conn->close();
?>
