<?php
session_start();

$user = null;
if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Introduction to Computer Science</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <link rel="stylesheet" href="index.css" />
</head>
<body>
  <header>
    <div class="container header-inner">
      <div class="logo">
        <img src="Images/floppy_icon.svg" alt="CS Club Logo" />
        <span>CS Club</span>
      </div>

      <nav id="nav-menu">
        <a href="#">Home</a>
        <a href="#">About Us</a>
        <a href="#">Roadmap</a>
        <a href="#">Testimonials</a>
        
        <?php if ($user): ?>
            <a href="./dashboard.php">
            <img src="Images/user_icon.svg" alt="User Icon" class="user-icon" />
            </a>
        <?php else: ?>
            <a href="./login.php">
            <img src="Images/user_icon.svg" alt="User Icon" class="user-icon" />
            </a>
        <?php endif; ?>

        <i class="fas fa-times close-menu" onclick="toggleMenu()"></i>
      </nav>

        <i class="fas fa-times close-menu" onclick="toggleMenu()"></i>
      </nav>
      <i class="fas fa-bars hamburger" onclick="toggleMenu()"></i>
    </div>
  </header>

  <main>
    <div class="container">
      <section class="hero">
        <div class="text-content">
          <button class="tag">Featured Course</button>
          <h1>Introduction to<br /><span>Computer Science</span></h1>
          <a href="./signup.html" class="cta-button">Start learning for free</a>
        </div>
        <div class="hero-illustration">
          <img src="Images/code_editor.svg" alt="Code Editor" />
        </div>
      </section>
    </div>

    <section id="about" class="about-section">
      <div class="container about-container">
        <div class="about-image">
          <img src="Images/about_us_photo.png" alt="About CS Club" />
        </div>
        <div class="about-text">
          <h2>About Us</h2>
          <p>
            Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum.
          </p>
        </div>
      </div>
    </section>

    <section class="roadmap-section">
      <div class="container">
        <h2>Roadmap</h2>
        <div class="roadmap-cards">
          <div class="roadmap-card" style="background-image: url('./images/python-bg.svg');">
            <h3>Introduction to<br>Python Programming</h3>
            <a href="#">Learn more →</a>
          </div>
          <div class="roadmap-card" style="background-image: url('./images/java-bg.svg');">
            <h3>Programming in<br>Java</h3>
            <a href="#">Learn more →</a>
          </div>
        </div>
      </div>
    </section>

    <section id="testimonials" class="testimonials-section">
      <div class="container">
        <h2>What Our Students Say</h2>
        <div class="testimonial-cards">
          <div class="testimonial-card">
            <img src="Images/person1.jpg" class="profile-img" alt="Student 1" />
            <p>"Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum."</p>
            <span>- Aryan S.</span>
          </div>
          <div class="testimonial-card">
            <img src="Images/person2.jpg" class="profile-img" alt="Student 2" />
            <p>"Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum."</p>
            <span>- Aryan S.</span>
          </div>
          <div class="testimonial-card">
            <img src="Images/person3.jpg" class="profile-img" alt="Student 3" />
            <p>"Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum,Lorem Ipsum."</p>
            <span>- Aryan S.</span>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    function toggleMenu() {
      const nav = document.getElementById('nav-menu');
      nav.classList.toggle('open');
    }
  </script>
</body>
</html>
