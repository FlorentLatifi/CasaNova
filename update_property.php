<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $property_id = $_POST['property_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    
    // Menaxhimi i fotos së re nëse është ngarkuar
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Merr foton e vjetër për ta fshirë
        $sql = "SELECT image_url FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $property_id);
        $stmt->execute();
        $old_image = $stmt->get_result()->fetch_assoc();
        
        // Fshi foton e vjetër nëse ekziston
        if ($old_image && !empty($old_image['image_url'])) {
            $old_image_path = "fotot/" . $old_image['image_url'];
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }
        
        // Ngarko foton e re
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = "fotot/" . $image_name;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_update = ", image_url = ?";
            $image_url = $image_name;
        }
    }
    
    // Përditëso të dhënat e pronës
    $sql = "UPDATE products SET 
            title = ?, 
            price = ?, 
            area = ?, 
            bedrooms = ?, 
            bathrooms = ?
            " . (isset($image_update) ? $image_update : "") . "
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (isset($image_update)) {
        $stmt->bind_param("ssssss", $title, $price, $area, $bedrooms, $bathrooms, $image_url, $property_id);
    } else {
        $stmt->bind_param("sssssi", $title, $price, $area, $bedrooms, $bathrooms, $property_id);
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
    
    header("Location: manage_properties.php");
    exit();
}
?> 