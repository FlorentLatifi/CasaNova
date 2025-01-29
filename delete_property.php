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
$sql = "SELECT title, image_url FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

// Regjistro veprimin në product_actions para se të fshihet prona
$action_sql = "INSERT INTO product_actions (product_id, user_id, action_type, action_details) 
              VALUES (?, ?, 'delete', ?)";
$action_details = "Property deleted: " . ($property ? $property['title'] : 'Unknown property');
$stmt = $conn->prepare($action_sql);
$stmt->bind_param("iis", $property_id, $_SESSION['user_id'], $action_details);
$stmt->execute();

// Fshi foton nëse ekziston
if ($property && !empty($property['image_url'])) {
    $image_path = "fotot/" . $property['image_url'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Delete the property from database
$delete_sql = "DELETE FROM products WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $property_id);

if ($delete_stmt->execute()) {
    $_SESSION['success'] = "Property successfully deleted.";
} else {
    $_SESSION['error'] = "Error deleting property: " . $conn->error;
}

// Close all prepared statements
if (isset($stmt)) $stmt->close();
if (isset($delete_stmt)) $delete_stmt->close();

// Redirect back to manage properties page
header("Location: manage_properties.php");
exit();
?> 