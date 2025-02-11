<?php
session_start();
require_once 'db_connection.php';
require_once 'classes/Property.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $property = new Property($conn);
    
    if (!$property->validate($_POST)) {
        $_SESSION['errors'] = $property->getErrors();
        header("Location: edit_property.php?id=" . $_POST['property_id']);
        exit();
    }

    $property_id = $_POST['property_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $image = $_FILES['image']['name'];
    $target = "fotot/" . basename($image);

    if (!empty($image) && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "UPDATE products SET title = ?, price = ?, area = ?, bedrooms = ?, bathrooms = ?, image_url = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiissi", $title, $price, $area, $bedrooms, $bathrooms, $image, $property_id);
    } else {
        $sql = "UPDATE products SET title = ?, price = ?, area = ?, bedrooms = ?, bathrooms = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiissi", $title, $price, $area, $bedrooms, $bathrooms, $property_id);
    }

    if ($stmt->execute()) {
        // Regjistro veprimin në product_actions
        $action_sql = "INSERT INTO product_actions (product_id, user_id, action_type, action_details) 
                      VALUES (?, ?, 'edit', ?)";
        $action_details = "Property updated: " . $title;
        $log_stmt = $conn->prepare($action_sql);
        $log_stmt->bind_param("iis", $property_id, $_SESSION['user_id'], $action_details);
        $log_stmt->execute();
        
        $_SESSION['success'] = "Property updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating property: " . $conn->error;
    }

    $stmt->close();
    
    header("Location: manage_properties.php");
    exit();
}
?>