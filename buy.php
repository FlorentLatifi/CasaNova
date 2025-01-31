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
$query_houses = "SELECT * FROM products WHERE type = 'sale' AND status = 'available' ORDER BY created_at DESC LIMIT 3";
$result_houses = mysqli_query($conn, $query_houses);

// Merr shtëpitë për qira nga databaza
$query_rentals = "SELECT * FROM products WHERE type = 'rent' AND status = 'available' ORDER BY created_at DESC LIMIT 3";
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
              <a href="property-details.php?id=<?php echo $house['id']; ?>&type=sale" class="buy-button">View Details</a>
            </div>
          </div>
        <?php endwhile; ?>
      </section>

      <h2 class="section-title">Houses for Rent</h2>
      <section class="house-listings">
        <?php while($rental = mysqli_fetch_assoc($result_rentals)): ?>
          <div class="house">
            <?php 
              $image_path = !empty($rental['image_url']) ? "fotot/" . $rental['image_url'] : "fotot/default-house.jpg";
              echo "<!-- Debug: Using image path: " . $image_path . " -->";
            ?>
            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                 alt="<?php echo htmlspecialchars($rental['title']); ?>" 
                 class="house-img" 
                 onerror="this.src='fotot/default-house.jpg'"/>
            <div class="house-details">
              <h2><?php echo htmlspecialchars($rental['title']); ?></h2>
              <div class="property-info">
                <span><i class="fas fa-ruler-combined"></i> <?php echo htmlspecialchars($rental['area']); ?> m²</span>
                <span><i class="fas fa-bed"></i> <?php echo htmlspecialchars($rental['bedrooms']); ?> Bedrooms</span>
                <span><i class="fas fa-bath"></i> <?php echo htmlspecialchars($rental['bathrooms']); ?></span>
              </div>
              <p><i class="fas fa-star"></i> <?php echo htmlspecialchars($rental['features']); ?></p>
              <p class="price">$<?php echo number_format($rental['price']); ?></p>
              <a href="property-details.php?id=<?php echo $rental['id']; ?>&type=rent" class="rent-button">View Details</a>
            </div>
          </div>
        <?php endwhile; ?>
      </section>
    </main>

    <?php include 'footer.php'; ?>

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
