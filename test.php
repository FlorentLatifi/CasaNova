<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Slider</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="slider.css">
  <link rel="stylesheet" href="navbar.css">
</head>
<body>
<?php require 'nav.php'; ?>

  <div class="slider-container">
    <?php
    // Move images array to TOP
    $images = [
      ["src" => "fotot/img1.jpg", "title" => "Image 1", "description" => "This is the first image."],
      ["src" => "fotot/img2.jpg", "title" => "Image 2", "description" => "This is the second image."],
      ["src" => "fotot/img3.jpg", "title" => "Image 3", "description" => "This is the third image."],
      ["src" => "fotot/img4.jpg", "title" => "Image 4", "description" => "This is the fourth image."],
      ["src" => "fotot/img5.jpg", "title" => "Image 5", "description" => "This is the fifth image."]
    ];
    ?>
    
    <div class="progress-container">
      <?php foreach ($images as $index => $image): ?>
        <div class="progress-item" data-index="<?= $index ?>">
          <div class="progress-bar"></div>
        </div>
      <?php endforeach; ?>
    </div>

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
  </script>
</body>
</html>
