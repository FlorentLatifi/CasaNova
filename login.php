<?php
session_start();

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
    } else {
        echo "<script>alert('Email or password is missing!');</script>";
        exit;
    }


    
    // Query për të marrë password dhe role_id të përdoruesit
    $sql = "SELECT u.password, r.name AS role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Kontrollo nëse përdoruesi ekziston
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($user) {
        // Verifiko fjalëkalimin e dhënë kundrejt atij të kriptuar
        if (password_verify($password, $user['password'])) {
            // Vendos variablat e sesionit
            $_SESSION['email'] = $email; // Store email in session
            $_SESSION['role'] = $user['role_name']; // Store role in session
    
            // Redirekto sipas rolit të përdoruesit
            if ($user['role_name'] === 'SUPERADMIN') {
                header("Location: superadmin_dashboard.php");
                exit();
            } elseif ($user['role_name'] === 'ADMIN') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php");
                exit();
            }
        } else {
            // Fjalëkalimi i gabuar
            echo "<script>alert('Fjalëkalimi është i gabuar!');</script>";
        }
    } else {
        // Email-i nuk u gjet
        echo "<script>alert('Email-i nuk ekziston!');</script>";
    }


    // Free statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>