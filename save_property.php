<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $image = $_FILES['image']['name'];
    $target = "fotot/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (title, price, area, bedrooms, bathrooms, image_url, type, status) VALUES (?, ?, ?, ?, ?, ?, 'sale', 'available')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiss", $title, $price, $area, $bedrooms, $bathrooms, $image);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Property added successfully.";
        } else {
            $_SESSION['error'] = "Error adding property.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to upload image.";
    }
}

header("Location: manage_properties.php");
exit();
?>
