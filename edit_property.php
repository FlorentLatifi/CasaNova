<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$propertyId = $_GET['id'];

// Fetch property details from the database
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $propertyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Property not found.");
}

$property = $result->fetch_assoc();
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
            <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
            </div>

            <div class="form-group">
                <label for="area">Area (m²)</label>
                <input type="number" id="area" name="area" value="<?php echo htmlspecialchars($property['area']); ?>" required>
            </div>

            <div class="form-group">
                <label for="bedrooms">Bedrooms</label>
                <input type="number" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required>
            </div>

            <div class="form-group">
                <label for="bathrooms">Bathrooms</label>
                <input type="number" id="bathrooms" name="bathrooms" value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image">
                <img src="fotot/<?php echo htmlspecialchars($property['image_url']); ?>" alt="Property Image" style="max-width: 100px; margin-top: 10px;">
            </div>

            <div class="form-actions">
                <button type="submit">Update Property</button>
                <a href="manage_properties.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>