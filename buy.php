<?php

// Ensure the db_connection.php file exists in the same directory
if (!file_exists('db_connection.php')) {
    die("Database connection file not found.");
}

include 'db_connection.php';

// Check if the database connection is established
if (!isset($conn)) {
    die("Database connection error.");
}

session_start();

// Kontrollo nëse përdoruesi është i kyçur dhe merr rolin
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

// Merr shtëpitë për shitje nga databaza
$query_houses = "SELECT * FROM products WHERE type = 'sale' AND status = 'available' ORDER BY created_at DESC";
$result_houses = mysqli_query($conn, $query_houses);

// Merr shtëpitë për qira nga databaza
$query_rentals = "SELECT * FROM products WHERE type = 'rent' AND status = 'available' ORDER BY created_at DESC";
$result_rentals = mysqli_query($conn, $query_rentals);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buy Your Dream Home</title>
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/buy.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </head>
  <body>
    <?php include 'nav.php'; ?>

    <main>
      <section class="hero">
        <h1>Buy Your Dream Home</h1>
        <p>Find the perfect house for you and your family.</p>
      </section>

      <h2 class="section-title">Houses for Sale</h2>
      <section class="house-listings">
        <?php while($house = mysqli_fetch_assoc($result_houses)): ?>
          <div class="house">
            <?php 
              $image_path = !empty($house['image_url']) ? "fotot/" . $house['image_url'] : "fotot/default-house.jpg";
              echo "<!-- Debug: Using image path: " . $image_path . " -->";
            ?>
            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                 alt="<?php echo htmlspecialchars($house['title']); ?>" 
                 class="house-img" 
                 onerror="this.src='fotot/default-house.jpg'"/>
            <div class="house-details">
              <h2><?php echo htmlspecialchars($house['title']); ?></h2>
              <div class="property-info">
                <span><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($house['area']); ?> m²</span>
                <span><i class="fas fa-bed"></i> <?php echo htmlspecialchars($house['bedrooms']); ?> Bedrooms</span>
                <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($house['bathrooms']); ?> Bathrooms</span>
              </div>
              <p><i class="fas fa-star"></i> <?php echo htmlspecialchars($house['features']); ?></p>
              <p class="price">$<?php echo number_format($house['price']); ?></p>
              <button class="buy-button" onclick="handleBuy(<?php echo $house['id']; ?>)">View Details</button>
            </div>
          </div>
        <?php endwhile; ?>
      </section>

      <h2 class="section-title">Houses for Rent</h2>
      <section class="rental-listings">
        <?php while($rental = mysqli_fetch_assoc($result_rentals)): ?>
          <div class="rental">
            <?php 
              $image_path = !empty($rental['image_url']) ? "fotot/" . $rental['image_url'] : "fotot/default-house.jpg";
              echo "<!-- Debug: Using image path: " . $image_path . " -->";
            ?>
            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                 alt="<?php echo htmlspecialchars($rental['title']); ?>" 
                 class="rental-img" 
                 onerror="this.src='fotot/default-house.jpg'"/>
            <div class="rental-details">
              <h2><?php echo htmlspecialchars($rental['title']); ?></h2>
              <div class="property-info">
                <span><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($rental['area']); ?> m²</span>
                <span><i class="fas fa-bed"></i> <?php echo htmlspecialchars($rental['bedrooms']); ?> Bedrooms</span>
                <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($rental['bathrooms']); ?> Bathrooms</span>
              </div>
              <p><i class="fas fa-star"></i> <?php echo htmlspecialchars($rental['features']); ?></p>
              <p class="price">$<?php echo number_format($rental['price']); ?></p>
              <button class="rent-button" onclick="handleRent(<?php echo $rental['id']; ?>)">View Details</button>
            </div>
          </div>
        <?php endwhile; ?>
      </section>
    </main>

    <footer class="site-footer" id="footer">
      <div class="footer-wrapper">
        <div class="footer-section about">
          <h3>CasaNova</h3>
          <p>Elevate your lifestyle with thoughtfully designed homes, exceptional amenities, 
             and a vibrant community tailored for modern living.</p>
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
    </footer>

    <script>
      function handleBuy(houseId) {
        <?php if (!$isLoggedIn): ?>
          window.location.href = 'login.html';
        <?php else: ?>
          window.location.href = 'property-details.php?id=' + houseId + '&type=sale';
        <?php endif; ?>
      }

      function handleRent(rentalId) {
        <?php if (!$isLoggedIn): ?>
          window.location.href = 'login.html';
        <?php else: ?>
          window.location.href = 'property-details.php?id=' + rentalId + '&type=rent';
        <?php endif; ?>
      }

      function scrollToFooter(event) {
        event.preventDefault();
        const footer = document.getElementById('footer');
        if (footer) {
          footer.scrollIntoView({ behavior: 'smooth' });
        }
      }
    </script>
  </body>
</html>
