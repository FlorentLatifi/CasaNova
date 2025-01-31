<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
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
        <form class="add-property-form" action="save_property.php" method="POST" enctype="multipart/form-data">
            <h1>Add New Property</h1>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
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