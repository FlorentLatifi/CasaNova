<?php
session_start();
require_once 'db_connection.php';
require_once 'classes/Property.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

$property = new Property($conn);
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);

// Merr të dhënat e pronës
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $propertyData = $result->fetch_assoc();

    if (!$propertyData) {
        $_SESSION['error'] = "Property not found.";
        header("Location: manage_properties.php");
        exit();
    }
} else {
    header("Location: manage_properties.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property - CasaNova</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="edit-property-container">
        <form class="edit-property-form" action="update_property.php" method="POST" enctype="multipart/form-data">
            <h1>Edit Property</h1>
            <input type="hidden" name="property_id" value="<?php echo htmlspecialchars($propertyData['id']); ?>">
            
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" 
                    value="<?php echo htmlspecialchars($propertyData['title'] ?? ''); ?>" required>
                <?php if (isset($errors['title'])): ?>
                    <div class="error-message"><?php echo $errors['title']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="sale" <?php echo ($propertyData['type'] ?? '') == 'sale' ? 'selected' : ''; ?>>For Sale</option>
                    <option value="rent" <?php echo ($propertyData['type'] ?? '') == 'rent' ? 'selected' : ''; ?>>For Rent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" 
                    value="<?php echo htmlspecialchars($propertyData['price'] ?? ''); ?>" required>
                <?php if (isset($errors['price'])): ?>
                    <div class="error-message"><?php echo $errors['price']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="area">Area (m²):</label>
                <input type="number" step="0.01" id="area" name="area" 
                    value="<?php echo htmlspecialchars($propertyData['area'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="bedrooms">Bedrooms:</label>
                <input type="number" id="bedrooms" name="bedrooms" 
                    value="<?php echo htmlspecialchars($propertyData['bedrooms'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="bathrooms">Bathrooms:</label>
                <input type="number" id="bathrooms" name="bathrooms" 
                    value="<?php echo htmlspecialchars($propertyData['bathrooms'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="features">Features:</label>
                <textarea id="features" name="features" required><?php echo htmlspecialchars($propertyData['features'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">Update Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if (!empty($propertyData['image_url'])): ?>
                    <div class="current-image">
                        <p>Current Image:</p>
                        <img src="fotot/<?php echo htmlspecialchars($propertyData['image_url']); ?>" 
                             alt="Current Property Image" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
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