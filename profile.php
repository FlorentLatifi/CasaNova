<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Merr të dhënat e përdoruesit
$user_id = $_SESSION['user_id'];
$sql = "SELECT u.*, r.name as role_name 
        FROM users u 
        JOIN roles r ON u.role_id = r.id 
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Përditëso profilin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    
    // Nëse fjalëkalimi është ndryshuar
    if (!empty($_POST['new_password'])) {
        if (password_verify($_POST['current_password'], $user['password'])) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET emri = ?, mbiemri = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $emri, $mbiemri, $email, $new_password, $user_id);
        } else {
            $error = "Current password is incorrect";
        }
    } else {
        $sql = "UPDATE users SET emri = ?, mbiemri = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $emri, $mbiemri, $email, $user_id);
    }
    
    if (!isset($error) && $stmt->execute()) {
        $success = "Profile updated successfully";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CasaNova</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="dashboard-container">
        <h1>My Profile</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="profile-form">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="emri">First Name</label>
                    <input type="text" id="emri" name="emri" value="<?php echo $user['emri']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="mbiemri">Last Name</label>
                    <input type="text" id="mbiemri" name="mbiemri" value="<?php echo $user['mbiemri']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" value="<?php echo $user['role_name']; ?>" readonly>
                </div>

                <h3>Change Password</h3>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password">
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password">
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 