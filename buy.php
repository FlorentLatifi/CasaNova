<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është i kyçur dhe merr rolin
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buy Your Dream Home</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="buy.css" />
   
  </head>
  <body>
    <!-- Përfshij nav.php -->
    <?php include 'nav.php'; ?>

    <!-- Main Content -->
    <main>
      <!-- Hero Section -->
      <section class="hero">
        <h1>Buy Your Dream Home</h1>
        <p>Find the perfect house for you and your family.</p>
      </section>

      <!-- Hidden Login Modal -->
      <div class="login-container hidden">
        <h1>Login</h1>
        <form action="" method="get" class="login-form">
          <div class="form-group">
            <input type="text" placeholder="Username" required />
          </div>
          <div class="form-group">
            <input type="password" placeholder="Password" required />
          </div>
          <button type="submit" class="submit-btn">Login</button>
        </form>
        <p class="signup-link">
          Don't have an account? <a href="signup.html">Sign up here</a>.
        </p>
        <button id="close-login" class="close-btn">X</button>
      </div>

      <!-- House Listings Section -->
      <section class="house-listings">
        <!-- House 1 -->
        <div class="house">
          <img
            src="fotot/vecteezy_modern-architectural-home-with-pool-at-dusk-in-tranquil-setting_48833439.jpeg"
            alt="Modern Villa"
            class="house-img"
          />
          <div class="house-details">
            <h2>Modern Villa</h2>
            <p>🏠 250 m² | 🛏️ 4 Bedrooms | 🛁 3 Bathrooms</p>
            <p>🌟 Features: Private pool, garden, and garage</p>
            <p class="price">$350,000</p>
            <button class="buy-btn" onclick="handleBuy()">Buy Now</button>
          </div>
        </div>

        <!-- House 2 -->
        <div class="house">
          <img
            src="fotot/shtepi_363-1536x861.jpg"
            alt="Family House"
            class="house-img"
          />
          <div class="house-details">
            <h2>Family House</h2>
            <p>🏠 180 m² | 🛏️ 3 Bedrooms | 🛁 2 Bathrooms</p>
            <p>🌟 Features: Spacious living room and backyard</p>
            <p class="price">$250,000</p>
            <button class="buy-btn" onclick="handleBuy()">Buy Now</button>
          </div>
        </div>

        <div class="house">
          <img
            src="fotot/cozy-apartment-living-room.jpg"
            alt="Family House"
            class="house-img"
          />
          <div class="house-details">
            <h2>Cozy Apartment</h2>
            <p>🏠 200 m² | 🛏️ 3 Bedrooms | 🛁 2 Bathrooms</p>
            <p>🌟 Features: Comfortable Apartment</p>
            <p class="price">$350,000</p>
            <button class="buy-btn" onclick="handleBuy()">Buy Now</button>
          </div>
        </div>

        <div class="house">
          <img
            src="fotot/bd1025af-e29c-4fcf-b409-16446a83f607-dubai1-sothebys.jpg"
            alt="Penthouse"
            class="house-img"
          />
          <div class="house-details">
            <h2>Luxury Penthouse</h2>
            <p>🏠 300 m² | 🛏️ 3 Bedrooms | 🛁 3 Bathrooms</p>
            <p>🌟 Features: Spacious living room and personal gym</p>
            <p class="price">$550,000</p>
            <button class="buy-btn" onclick="handleBuy()">Buy Now</button>
          </div>
        </div>
      </section>
    </main>
    <h2 style="text-align: center; padding-top: 3em">Rent a house</h2>
    <section class="rental-listings">
      <!-- Rental 1 -->
      <div class="rental">
        <img
          src="fotot/DALL·E-2023-11-13-16.50.55-Wide-angle-photo-of-a-modern-small-apartment-living-room-in-landscape-perspective.-The-design-maximizes-space-with-multi-functional-furniture-like-a-s-1024x585.png"
          alt="Luxury Apartment with a stunning view"
          class="rental-img"
        />
        <div class="rental-details">
          <h2>Luxury Apartment</h2>
          <p>🏠 120 m² | 🛏️ 2 Bedrooms | 🛁 2 Bathrooms</p>
          <p>🌟 Features: Balcony with a city view, gym access</p>
          <p class="price">$1,800/month</p>
          <button class="buy-btn" onclick="handleRent()">Rent Now</button>
        </div>
      </div>

      <!-- Rental 2 -->
      <div class="rental">
        <img
          src="fotot/Maly-tripodlazni-dum-s-cihelnym-obkladem-a-anglickym-nadechem-Hradec-Kralove-01___media_library_original_1567_881.jpg"
          alt="Cozy Family Home with a backyard"
          class="rental-img"
        />
        <div class="rental-details">
          <h2>Cozy Family Home</h2>
          <p>🏠 150 m² | 🛏️ 3 Bedrooms | 🛁 2 Bathrooms</p>
          <p>🌟 Features: Large backyard, pet-friendly</p>
          <p class="price">$2,500/month</p>
          <button class="buy-btn" onclick="handleRent()">Rent Now</button>
        </div>
      </div>

      <div class="rental">
        <img
          src="fotot/Combining-textures-like-velvet-leather-and-metallic-accents-can-add-depth-and-visual-interest-to-a-modern-condo-living-room-design.jpg"
          class="rental-img"
          style="height: 70vh"
        />
        <div class="rental-details">
          <h2>Modern Condo</h2>
          <p>🏠 90 m² | 🛏️ 1 Bedroom | 🛁 1 Bathroom</p>
          <p>🌟 Features: Pool access, security, and rooftop lounge</p>
          <p class="price">$1,200/month</p>
          <button class="buy-btn" onclick="handleRent()">Rent Now</button>
        </div>
      </div>

      <!-- Rental 4 -->
      <div class="rental">
        <img
          src="fotot/2270901_cainc0259_1-2000-36b6699219454ee298de1d4565f1ab7d.jpg"
          alt="Peaceful Rural Cottage"
          class="rental-img"
        />
        <div class="rental-details">
          <h2>Rural Cottage</h2>
          <p>🏠 110 m² | 🛏️ 2 Bedrooms | 🛁 1 Bathroom</p>
          <p>🌟 Features: Quiet countryside, large garden</p>
          <p class="price">$900/month</p>
          <button class="buy-btn" onclick="handleRent()">Rent Now</button>
        </div>
      </div>
    </section>

    <footer class="site-footer" id="footer">
      <div class="footer-wrapper">
        <div class="footer-section about">
          <h3>CasaNova</h3>
          <p>
            Elevate your lifestyle with thoughtfully designed homes, exceptional
            amenities, and a vibrant community tailored for modern living.
          </p>
        </div>

        <div class="footer-section links">
          <h4>Explore</h4>
          <ul>
            <li><a href="#intro" class="scroll-to-top">Home</a></li>
            <li><a href="#">Buy</a></li>
            <li><a href="#">Sell</a></li>
            <li><a href="#">Rent</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>

        <div class="footer-section contact">
          <h4>Get in Touch</h4>
          <p>Email: info@casanova.com</p>
          <p>Phone: +383 44 123 456</p>
          <p>Location: Prishtina, Kosovo</p>
        </div>

        <div class="footer-section social">
          <h4>Connect</h4>
          <div class="social-links">
            <a href="https://www.instagram.com/">
              <img src="fotot/insta.webp" alt="Instagram" class="social-icon" />
            </a>
            <a href="https://www.facebook.com/">
              <img
                src="fotot/facebook.png"
                alt="Facebook"
                class="social-icon"
              />
            </a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2024 CasaNova. All rights reserved.</p>
      </div>
      <div></div>
    </footer>

    <!-- JavaScript -->
    <script>
      // Get the modal and the close button
      const modal = document.querySelector(".login-container");
      const closeBtn = document.querySelector("#close-login");

      // Add event listener to all buttons with the class 'open-login-btn'
      document.querySelectorAll(".buy-btn").forEach((button) => {
        button.addEventListener("click", () => {
          modal.classList.remove("hidden"); // Show the modal
        });
      });

      // Close the modal when the close button (X) is clicked
      closeBtn.addEventListener("click", () => {
        modal.classList.add("hidden"); // Hide the modal
      });

      // Optional: Close the modal when clicking outside the modal
      window.addEventListener("click", (event) => {
        if (event.target === modal) {
          modal.classList.add("hidden");
        }
      });
    </script>
  </body>
</html>
