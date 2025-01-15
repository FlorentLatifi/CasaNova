<?php
// Include the database connection
include 'db_connection.php'; // Ensure you have a correct connection

// Fetch the list of users
$sql = "SELECT u.id, u.emri, u.mbiemri, u.email, r.name AS roli 
        FROM users u 
        JOIN roles r ON u.role_id = r.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data for each user
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["emri"] . " " . $row["mbiemri"] . " - Email: " . $row["email"] . " - Role: " . $row["roli"] . "<br>";
    }
} else {
    echo "No users found.";
}

// Close the database connection
$conn->close();
?>
