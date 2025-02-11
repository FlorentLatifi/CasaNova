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
    $type = $_POST['type'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $features = $_POST['features'];
    
    // Menaxhimi i ngarkimit të fotos
    $target_dir = "fotot/";
    $image_url = "";
    
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        
        // Debug informacion
        error_log("Trying to upload file: " . $target_file);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $image_name;
            error_log("File uploaded successfully. Image URL: " . $image_url);
        } else {
            error_log("Failed to upload file. Error: " . $_FILES["image"]["error"]);
        }
    }
    
    // Përdor prepared statement për të ruajtur të dhënat
    $sql = "INSERT INTO products (title, type, price, area, bedrooms, bathrooms, features, image_url, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'available')";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssss", $title, $type, $price, $area, $bedrooms, $bathrooms, $features, $image_url);
        
        if ($stmt->execute()) {
            $product_id = $conn->insert_id;
            
            // Regjistro veprimin
            $action_sql = "INSERT INTO product_actions (product_id, user_id, action_type, action_details) 
                          VALUES (?, ?, 'add', ?)";
            $action_details = "Added new property: " . $title;
            $stmt = $conn->prepare($action_sql);
            $stmt->bind_param("iis", $product_id, $_SESSION['user_id'], $action_details);
            $stmt->execute();
            
            header("Location: manage_properties.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property - CasaNova</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="add-property-container">
        <form class="add-property-form" action="" method="POST" enctype="multipart/form-data">
            <h1>Add New Property</h1>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="sale">For Sale</option>
                    <option value="rent">For Rent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="area">Area (m²)</label>
                <input type="number" id="area" name="area" required>
            </div>

            <div class="form-group">
                <label for="bedrooms">Bedrooms</label>
                <input type="number" id="bedrooms" name="bedrooms" required>
            </div>

            <div class="form-group">
                <label for="bathrooms">Bathrooms</label>
                <input type="number" id="bathrooms" name="bathrooms" required>
            </div>

            <div class="form-group">
                <label for="features">Features</label>
                <textarea id="features" name="features" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" required>
            </div>

            <div class="form-actions">
                <button type="submit">Add Property</button>
                <a href="manage_properties.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>