<?php
session_start();

// Check if user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CasaNova</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </head>
  <body>
    <?php include 'nav.php'; ?>

    <div class="header" id="intro">
      <div class="header-content">
        <h1>Welcome to <span>CasaNova Neighborhood</span></h1>
        <h3><b>Where Every Home Becomes Part of a Timeless Story</b></h3>
        <div class="header-actions">
          <ul>
            <li><a href="buy.php">Buy</a></li>
            <li><a href="sell.php">Sell</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="main">
      <div class="main-content" id="main">
        <h3 class="h3-main">Welcome to CasaNova: A Vision for Modern Living</h3>
        <div class="main-p">
          CasaNova Township is a testament to our belief that elevating the
          standard of living is not just a dream, but a reality brought to life.
        </div>
        <div class="main-p">
          Envisioned with inspiration from the world's most advanced
          infrastructure and crafted by globally acclaimed architects, this
          ambitious project is being executed by the largest architectural firm
          in Kosovo. Our goal is to deliver a township that stands out in every
          way, offering a truly unique living experience.
        </div>
      </div>
    </div>
    <div class="main amenities-section">
      <h2>Our Amenities</h2>

      <ul>
        <li>Community Parks and Green Spaces</li>
        <li>Modern Fitness Centers</li>
        <li>Swimming Pools and Sports Facilities</li>
        <li>Shopping Malls and Restaurants</li>
        <li>24/7 Security</li>
      </ul>
    </div>

    <div class="photo-gallery">
      <h2>Gallery</h2>
      <div class="photo-grid">
        <div class="photo-item">
          <img
            src="./fotot/moderni-drevostavba-jako-misto-pro-setkavani-cele-rodiny-drazejov-01.jpg"
            alt="Modern Home"
          />
          <h3>Modern Architecture</h3>
        </div>
        <div class="photo-item">
          <img src="./fotot/11908eu.jpeg" alt="Community Park" />
          <h3>Community Park</h3>
        </div>
        <div class="photo-item">
          <img src="./fotot/Gated_neighborhood-1024x683-2.jpg" alt="Security" />
          <h3>Security</h3>
        </div>
        <div class="photo-item">
          <img
            src="./fotot/MicrosoftTeams-image-499-1-min-1536x864.jpg"
            alt="Sport Center"
          />
          <h3>Sport Centers</h3>
        </div>
      </div>
    </div>

    <section class="house-gallery" id="house">
      <h2>Available Properties</h2>
      <div class="house-container">
        <!-- House 1 -->
        <div class="house-card" id="house1">
          <img
            src="fotot/moderni-drevostavba-jako-misto-pro-setkavani-cele-rodiny-drazejov-01.jpg"
            alt="Modern House"
          />
          <div class="house-details">
            <h3>Modern House</h3>
            <p>Area: 250 m²</p>
            <p>Rooms: 4 Bedrooms, 3 Bathrooms</p>

            <a href="buy.htm" class="buy-button">Buy</a>
          </div>
        </div>

        <!-- House 2 -->
        <div class="house-card">
          <img
            src="fotot/k-lesu-celem-k-mestu-zady-1___media_library_original_1567_881.jpg"
            alt="Luxury Villa"
          />
          <div class="house-details">
            <h3>Luxury Villa</h3>
            <p>Area: 350 m²</p>
            <p>Rooms: 5 Bedrooms, 4 Bathrooms</p>

            <a href="buy.htm" class="buy-button">Buy</a>
          </div>
        </div>

        <!-- House 3 -->
        <div class="house-card">
          <img
            src="fotot/Maly-tripodlazni-dum-s-cihelnym-obkladem-a-anglickym-nadechem-Hradec-Kralove-01___media_library_original_1567_881.jpg"
          />
          <div class="house-details">
            <h3>Cozy Cottage</h3>
            <p>Area: 180 m²</p>
            <p>Rooms: 3 Bedrooms, 2 Bathrooms</p>

            <a href="buy.htm" class="buy-button">Buy</a>
          </div>
        </div>

        <!-- House 4 -->
        <div class="house-card">
          <img
            src="fotot/shitet-shtepija-ne-veternik-lagjja-qendresa-207m2.jpeg"
            alt="Contemporary Home"
          />
          <div class="house-details">
            <h3>Contemporary Home</h3>
            <p>Area: 300 m²</p>
            <p>Rooms: 4 Bedrooms, 3 Bathrooms</p>

            <a href="buy.htm" class="buy-button">Buy</a>
          </div>
        </div>
      </div>
    </section>

    <div class="testimonials">
      <h2>What Our Clients Say</h2>
      <div class="testimonial">
        <p>
          "Living in CasaNova has been a dream come true. The amenities and
          community are unmatched!"
        </p>
        <h4><img src="fotot/girlpfp.png" alt="" class="leart" /> - Jane Doe</h4>
      </div>
      <div class="testimonial">
        <p>
          "The homes are beautifully designed, and the neighborhood is safe and
          welcoming."
        </p>
        <h4>
          <img src="fotot/leart.png" alt="" class="leart" /> - Leart Bokshi
        </h4>
      </div>
      <div class="testimonial">
        <p>
          "I love the peaceful environment here. It's the perfect place to raise
          a family!"
        </p>
        <h4>
          <img src="fotot/leartii.png" alt="" class="leart" /> - John Johnson
        </h4>
      </div>
    </div>

    <div class="faq">
      <h2>Frequently Asked Questions</h2>
      <h4>How do I book a property?</h4>
      <p>You can contact us directly or schedule a tour through our website.</p>
      <h4>Are there financing options available?</h4>
      <p>
        Yes, we work with multiple financial institutions to provide mortgage
        options.
      </p>

      <h4>Is CasaNova suitable for families?</h4>
      <p>
        Absolutely! CasaNova is designed with families in mind, featuring safe
        play areas, excellent schools nearby, and a family-friendly environment.
      </p>

      <h4>Can I customize my home?</h4>
      <p>
        Yes, we offer customization packages to tailor your new home to your
        preferences and lifestyle.
      </p>
    </div>

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
  </body>
</html>
