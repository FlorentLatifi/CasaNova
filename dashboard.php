<?php
include 'db_connection.php';
session_start();

// Check if the user is a superadmin
if ($_SESSION['user_role'] != 3) { // Assuming 3 is the role_id for superadmin
    die("Access denied.");
}

// Fetch the list of users
$sql = "SELECT u.id, u.emri, u.mbiemri, u.email, r.name AS roli 
        FROM users u 
        JOIN roles r ON u.role_id = r.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CasaNova</title>
    <link rel="stylesheet" href="dashboard.css">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }
    </script>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="superadmin_dashboard.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>User Management</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['emri']}</td>
                            <td>{$row['mbiemri']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['roli']}</td>
                            <td>
                                <a href='edit_user.php?id={$row['id']}' class='edit-button'>Edit</a> | 
                                <form action='delete_user.php' method='POST' style='display:inline;' onsubmit='return confirmDelete();'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>
        </table>
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
