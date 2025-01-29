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
    header("Location: manage_properties.php");
    exit();
}

$property_id = $_GET['id'];

// Fetch property details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage_properties.php");
    exit();
}

$property = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property - CasaNova</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="dashboard-container">
        <div class="header-actions">
            <h1>Edit Property</h1>
            <a href="manage_properties.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Properties
            </a>
        </div>

        <form action="update_property.php" method="POST" enctype="multipart/form-data" class="property-form">
            <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
            
            <div class="form-group">
                <label for="title">Property Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($property['description']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price (€)</label>
                    <input type="number" id="price" name="price" value="<?php echo $property['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="area">Area (m²)</label>
                    <input type="number" id="area" name="area" value="<?php echo $property['area']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bedrooms">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms" value="<?php echo $property['bedrooms']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms" value="<?php echo $property['bathrooms']; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="available" <?php echo $property['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                    <option value="sold" <?php echo $property['status'] == 'sold' ? 'selected' : ''; ?>>Sold</option>
                    <option value="pending" <?php echo $property['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>

            <div class="form-group">
                <label for="new_image">Update Image (leave empty to keep current image)</label>
                <input type="file" id="new_image" name="new_image" accept="image/*">
                <input type="hidden" name="current_image" value="<?php echo $property['image']; ?>">
            </div>

            <div class="current-image">
                <p>Current Image:</p>
                <img src="<?php echo $property['image']; ?>" alt="Current Property Image" style="max-width: 200px;">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Property</button>
                <a href="manage_properties.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['property_id'])) {
        $property_id = $_POST['property_id'];
        $title = $_POST['title'];

        // Update property in the database
        $sql = "UPDATE products SET title = ?, description = ?, price = ?, area = ?, bedrooms = ?, bathrooms = ?, location = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $_POST['title'], $_POST['description'], $_POST['price'], $_POST['area'], $_POST['bedrooms'], $_POST['bathrooms'], $_POST['location'], $_POST['status'], $property_id);

        if ($stmt->execute()) {
            // Regjistro veprimin në product_actions
            $action_sql = "INSERT INTO product_actions (product_id, user_id, action_type, action_details) 
                          VALUES (?, ?, 'edit', ?)";
            $action_details = "Property updated: " . $title;
            $log_stmt = $conn->prepare($action_sql);
            $log_stmt->bind_param("iis", $property_id, $_SESSION['user_id'], $action_details);
            $log_stmt->execute();
            $log_stmt->close();

            $_SESSION['success'] = "Property updated successfully.";
            header("Location: manage_properties.php");
            exit();
        } else {
            echo "Error updating property: " . $conn->error;
        }
    }
    ?>
</body>
</html> 