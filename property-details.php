<?php
include 'db_connection.php';

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Invalid request.");
}

$propertyId = $_GET['id'];
$propertyType = $_GET['type'];

// Fetch property details from the database
$sql = "SELECT * FROM products WHERE id = ? AND type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $propertyId, $propertyType);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Property not found.");
}

$property = $result->fetch_assoc();
$image_url = !empty($property['image_url']) ? htmlspecialchars($property['image_url']) : 'default-house.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($property['title']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <section class="hero" style="background-image: url('fotot/<?php echo $image_url; ?>');">
        <h1>Buy Your Dream Home</h1>
        <p>Find the perfect house for you and your family.</p>
    </section>

    <div class="property-details-container">
        <div class="property-details">
            <h1><?php echo htmlspecialchars($property['title']); ?></h1>
            <p><strong>Area:</strong> <?php echo htmlspecialchars($property['area']); ?> m²</p>
            <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['bedrooms']); ?></p>
            <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['bathrooms']); ?></p>
            <p><strong>Features:</strong> <?php echo htmlspecialchars($property['features']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($property['price']); ?></p>
            <p><strong>Contact Phone:</strong> +383 44 123 456</p>
            <p><strong>Contact Email:</strong> info@casanova.com</p>
        </div>
    </div>

    <footer class="site-footer" id="footer">
        <div class="footer-wrapper">
            <!-- ...existing code... -->
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
