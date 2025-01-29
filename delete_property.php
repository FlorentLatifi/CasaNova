<?php
session_start();
include 'db_connection.php';

// Check if user is admin or superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

// Check if property ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No property specified for deletion.";
    header("Location: manage_properties.php");
    exit();
}

$property_id = $_GET['id'];

// First, get the image filename before deleting the property
$sql = "SELECT image_url FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $property = $result->fetch_assoc();
    $image_path = 'fotot/' . $property['image_url'];

    // Delete the property from database
    $delete_sql = "DELETE FROM products WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $property_id);

    if ($delete_stmt->execute()) {
        // If database deletion successful, delete the image file
        if ($property['image_url'] && file_exists($image_path)) {
            unlink($image_path); // Delete the image file from the server
        }

        // Also delete any related records (like favorites)
        $delete_favorites_sql = "DELETE FROM favorites WHERE property_id = ?";
        $delete_favorites_stmt = $conn->prepare($delete_favorites_sql);
        $delete_favorites_stmt->bind_param("i", $property_id);
        $delete_favorites_stmt->execute();

        // Log the deletion
        $user_id = $_SESSION['user_id'];
        $log_sql = "INSERT INTO admin_logs (user_id, action, details) VALUES (?, 'property_delete', ?)";
        $log_stmt = $conn->prepare($log_sql);
        $details = "Deleted property ID: " . $property_id;
        $log_stmt->bind_param("is", $user_id, $details);
        $log_stmt->execute();

        $_SESSION['success'] = "Property successfully deleted.";
    } else {
        $_SESSION['error'] = "Error deleting property: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Property not found.";
}

// Close all prepared statements
if (isset($stmt)) $stmt->close();
if (isset($delete_stmt)) $delete_stmt->close();
if (isset($delete_favorites_stmt)) $delete_favorites_stmt->close();
if (isset($log_stmt)) $log_stmt->close();

// Redirect back to manage properties page
header("Location: manage_properties.php");
exit();
?> 