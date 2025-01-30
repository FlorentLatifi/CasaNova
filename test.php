<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Slider Modern</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="navbar.css">
  <link rel="stylesheet" href="slider.css">
</head>
<body>
<?php require 'nav.php'; ?>

  <div class="slider-container">
    <?php
    // Move images array to TOP
    $images = [
      ["src" => "fotot/img1.jpg", "title" => "Apartament Modern 80m^2", "description" => "Per familjen tuaj."],
      ["src" => "fotot/img2.jpg", "title" => "Apartament Modern 100m^2", "description" => "Per familjen tuaj."],
      ["src" => "fotot/img3.jpg", "title" => "Apartament Modern 70m^2", "description" => "Per familjen tuaj."],
      ["src" => "fotot/img4.jpg", "title" => "Apartament Modern 90m^2", "description" => "Per familjen tuaj."],
      ["src" => "fotot/img5.jpg", "title" => "Apartament Modern 80m^2", "description" => "Per familjen tuaj."]
    ];
    ?>
    
    <div class="slider" id="slider">
      <?php foreach ($images as $image): ?>
        <div class="slide">
          <img src="<?= $image['src'] ?>" alt="<?= $image['title'] ?>">
          <div class="caption">
            <h3><?= $image['title'] ?></h3>
            <p><?= $image['description'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="progress-container">
      <?php foreach ($images as $index => $image): ?>
        <div class="progress-item" data-index="<?= $index ?>">
          <div class="progress-bar"></div>
        </div>
      <?php endforeach; ?>
    </div>

    <button class="prev" onclick="prevSlide()">&#10094;</button>
    <button class="next" onclick="nextSlide()">&#10095;</button>
  </div>

  <script>
    let currentIndex = 0;
    const slides = document.querySelectorAll(".slide");
    const totalSlides = slides.length;
    let autoSlideInterval;

    function updateProgress() {
      document.querySelectorAll('.progress-bar').forEach((bar, index) => {
        bar.style.width = currentIndex === index ? '100%' : '0%';
      });
    }

    function prevSlide() {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateSlider();
      resetAutoSlide();
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateSlider();
      resetAutoSlide();
    }

    function updateSlider() {
      document.getElementById("slider").style.transform = `translateX(-${currentIndex * 100}%)`;
      updateProgress();
    }

    function resetAutoSlide() {
      clearInterval(autoSlideInterval);
      autoSlideInterval = setInterval(nextSlide, 5000);
    }

    // Initialize auto-slide
    resetAutoSlide();
    updateProgress();

    // Add touch support
    let touchStartX = 0;
    let touchEndX = 0;
    
    document.getElementById("slider").addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].screenX;
    });

    document.getElementById("slider").addEventListener('touchend', e => {
      touchEndX = e.changedTouches[0].screenX;
      if (touchStartX - touchEndX > 50) {
        nextSlide();
      } else if (touchEndX - touchStartX > 50) {
        prevSlide();
      }
    });
  </script>
</body>
</html>
