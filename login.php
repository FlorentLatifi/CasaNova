<?php
session_start();

$servername = "localhost";
$connectionOptions = [
    "Database" => "Projekti",
    "UID" => "Diar", // Replace with your MSSQL username
    "PWD" => "Diar2005", // Replace with your MSSQL password
];

// Establish connection to the MSSQL database
$conn = sqlsrv_connect($servername, $connectionOptions);
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
    } else {
        echo "<script>alert('Email or password is missing!');</script>";
        exit;
    }

    // Prepare and execute the SQL query to find the user
    $sql = "SELECT password, role FROM users WHERE email = ?";
    $params = [$email];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Query failed: " . print_r(sqlsrv_errors(), true));
    }

    // Check if the user exists
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($user) {
        // Verify the provided password against the hashed password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['email'] = $email; // Store email in session
            $_SESSION['role'] = $user['role']; // Store user role in session

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit;
            } else {
                header("Location: user_dashboard.php");
                exit;
            } 
          }  else {
            // Invalid password
            echo "<script>alert('Fjalëkalimi është i gabuar!');</script>";
        }
    } else {
        // Email not found
        echo "<script>alert('Email-i nuk ekziston!');</script>";
    }

    // Free statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>