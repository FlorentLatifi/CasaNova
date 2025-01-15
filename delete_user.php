<?php
// Include the database connection
include 'db_connection.php'; // Ensure you have a correct connection

// Check if ID is sent via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Prepare the SQL statement to prevent SQL injection
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        // Execute the SQL query
        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            die("Error deleting user: " . $stmt->error);
        }
    } else {
        die("User ID must be provided.");
    }
}

// Close the database connection
$conn->close();
?>
