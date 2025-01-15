<?php
session_start();

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['emri'];
                $_SESSION['user_role'] = $user['role_id']; // Assuming role_id is stored in the users table

                // Redirect based on user role
                switch ($_SESSION['user_role']) {
                    case 1: // Assuming 1 is for regular users
                        header("Location: user_dashboard.php");
                        break;
                    case 2: // Assuming 2 is for admins
                        header("Location: admin_dashboard.php");
                        break;
                    case 3: // Assuming 3 is for superadmins
                        header("Location: superadmin_dashboard.php");
                        break;
                    default:
                        die("Invalid user role.");
                }
                exit();
            } else {
                die("Invalid password.");
            }
        } else {
            die("No user found with that email.");
        }
    } else {
        die("Email and password must be provided.");
    }
}

// Close the database connection
$conn->close();
?>
