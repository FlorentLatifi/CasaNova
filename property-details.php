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
            <div class="footer-section about">
                <h3>CasaNova</h3>
                <p>Elevate your lifestyle with thoughtfully designed homes, exceptional amenities, and a vibrant community tailored for modern living.</p>
            </div>

            <div class="footer-section links">
                <h4>Explore</h4>
                <ul>
                    <li><a href="#intro">Home</a></li>
                    <li><a href="buy.php">Buy</a></li>
                    <li><a href="#">Sell</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section contact">
                <h4>Get in Touch</h4>
                <p><i class="fas fa-envelope"></i> info@casanova.com</p>
                <p><i class="fas fa-phone"></i> +383 44 123 456</p>
                <p><i class="fas fa-map-marker-alt"></i> Prishtina, Kosovo</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 CasaNova. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
