<?php
include 'db_connection.php';
session_start();

// Check if the user is a superadmin
if ($_SESSION['user_role'] != 3) { // Assuming 3 is the role_id for superadmin
    die("Access denied.");
}

// Fetch user ID from the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data from the database
    $sql = "SELECT u.id, u.emri, u.mbiemri, u.email, r.name AS roli 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
} else {
    die("No user ID provided.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - CasaNova</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <h1>Edit User</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Back to Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="emri">Name:</label>
            <input type="text" id="emri" name="emri" value="<?php echo $user['emri']; ?>" required>
            <br>
            <label for="mbiemri">Surname:</label>
            <input type="text" id="mbiemri" name="mbiemri" value="<?php echo $user['mbiemri']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            <br>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="1" <?php if ($user['roli'] == 'USER') echo 'selected'; ?>>User</option>
                <option value="2" <?php if ($user['roli'] == 'ADMIN') echo 'selected'; ?>>Admin</option>
                <option value="3" <?php if ($user['roli'] == 'SUPERADMIN') echo 'selected'; ?>>Superadmin</option>
            </select>
            <br>
            <button type="submit">Update User</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 CasaNova. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
