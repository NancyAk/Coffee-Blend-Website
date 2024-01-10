<?php
// Include the database connection file
include 'connection.php';

// Initialize variable to store error message
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $feedback = htmlspecialchars($_POST['message']);

  // Prepare and bind the SQL statement
  $sql = "INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($connection, $sql);

  // Bind parameters to the statement
  mysqli_stmt_bind_param($stmt, "sss", $name, $email, $feedback);

  // Execute the statement and check for success
  if (mysqli_stmt_execute($stmt)) {
    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($connection);

    // Use JavaScript to display an alert
    echo '<script>alert("Thank you for your feedback!");</script>';
  } else {
    $error = "Error: " . mysqli_stmt_error($stmt);
  }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Coffee Blend</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }

    nav {
      display: flex;
      justify-content: space-around;
      align-items: center;
      position: fixed;
      top: 0;
      right: 0;
      left: 0;
      background: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      z-index: 1000;
      transition: background 0.3s;
    }

    nav.fixed {
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    nav .logo img {
      width: 100px;
      cursor: pointer;
      margin: 7px 0;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      display: inline-block;
      margin: 0 15px;
    }

    nav ul li a {
      text-decoration: none;
      color: #000;
      font-weight: 500;
      font-size: 17px;
      transition: color 0.1s;
      position: relative;
    }

    nav ul li a::after {
      content: "";
      width: 0;
      height: 2px;
      background: #fac031;
      display: block;
      transition: width 0.2s linear;
      position: absolute;
      bottom: -5px;
      left: 0;
    }

    nav ul li a:hover::after {
      width: 100%;
    }

    nav ul li a:hover {
      color: #fac031;
    }

    nav .icon i {
      font-size: 18px;
      color: #000;
      margin: 0 5px;
      cursor: pointer;
      transition: color 0.3s;
    }

    nav .icon i:hover {
      color: #fac031;
    }

    .about_main {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }

    .image,
    .about_text {
      flex: 1 1 45%;
      margin: 1rem;
    }

    .image img {
      width: 100%;
      border-radius: 8px;
    }

    .about_text h3 {
      font-size: 1.5rem;
      color: #fac031;

    }

    .about_text h1 span {
      font-size: 2.5rem;
      color: #fac031;
      margin-bottom: 1rem;

    }

    .about_text h1 {
      font-size: 1.8rem;
      color: black;
      margin-top: 70px;
      font-weight: bold;
    }

    .about_text p {
      font-size: 1.1rem;
      color: black;
      line-height: 1.2;
      padding: 10px;
      border-radius: 1px;

      transition: background 0.3s;
    }

    .about_text p:hover {
      background: #fac031;
      color: #fff;
    }

    .main_btn a {
      background: #fac031;
      padding: 12px 25px;
      text-decoration: none;
      color: #fff;
      border-radius: 5px;
      font-weight: bold;
      display: inline-block;
      transition: background 0.3s, color 0.3s;
    }

    .main_btn a i {
      margin-left: 5px;
      transition: transform 0.3s;
    }

    .main_btn a:hover i {
      transform: translateX(7px);
    }

    footer {
      width: 100%;
      padding: 30px 0 0 20px;
      background: #eeeeee;
      position: relative;
      bottom: 0;
    }

    .footer_main {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      align-items: flex-start;
    }

    .footer_tag {
      text-align: center;
      margin: 1rem;
    }

    .footer_tag h2 {
      color: #000;
      margin-bottom: 25px;
      font-size: 30px;
    }

    .footer_tag p {
      margin: 10px 0;
    }

    .footer_tag i {
      margin: 0 5px;
      cursor: pointer;
      transition: color 0.3s;
    }

    .footer_tag i:hover {
      color: #fac031;
    }

    .end {
      text-align: center;
      padding: 15px;
    }

    .end span {
      color: #fac031;
      margin-left: 10px;
    }

    .end {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 15px;
    }

    .end span {
      color: #fac031;
      margin-left: 10px;
    }

    ::-webkit-scrollbar {
      width: 13px;
    }

    ::-webkit-scrollbar-track {
      border-radius: 15px;
      box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
    }

    ::-webkit-scrollbar-thumb {
      background: #fac031;
      border-radius: 15px;
    }

    /* Feedback styles */
    .feedback_main {
      text-align: center;
      padding: 80px 0;
      background: #fff;
    }

    .feedback_main h2 {
      color: #333;
      font-size: 2rem;
      margin-bottom: 20px;
    }

    #feedbackForm {
      max-width: 600px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 1.2rem;
      margin-bottom: 8px;
    }

    input,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    button {
      background-color: #fac031;
      color: #fff;
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
    }

    button:hover {
      background: #333;
      color: #fff;
    }
  </style>
</head>

<body>
  <nav>
    <div class="logo">
      <img src="image/logo.png" alt="Logo" />
    </div>
    <ul>
      <li><a href="index.html#Home">Home</a></li>
      <li><a href="index.html#About">About</a></li>
      <li><a href="index.html#Menu">Menu</a></li>
      <li><a href="index.html#Review">Review</a></li>
      <li><a href="index.html#team">Team</a></li>
    </ul>
  </nav>

  <section class="about_main">
    <div class="image">
      <img src="image/about2.jpg" alt="Coffee" />
    </div>
    <div class="about_text">
      <h1>Our<span>Story</span></h1>
      <p id="paragraph">
        Welcome to Coffee Blend, a place where the artistry of coffee-making
        meets the warmth of community. Our story began in the year 2023,
        driven by a shared passion for crafting exceptional coffee
        experiences. What started as a humble venture has evolved into a
        beloved destination for coffee enthusiasts and those seeking a
        welcoming atmosphere.
      </p>
      <h3>Our journey</h3>
      <p id="paragraph">
        In the heart of our journey lies a commitment to quality and a
        relentless pursuit of perfection. From the outset, we dedicated
        ourselves to sourcing the finest coffee beans from sustainable farms
        across the globe. This commitment to ethical practices ensures that
        each cup we serve is not just a beverage but a narrative of
        responsible sourcing and exquisite taste.
      </p>
      <h3>Craftsmanship Unveiled</h3>
      <p>
        At Coffee Blend, we view coffee-making as an art form. Behind the
        counter, our skilled baristas meticulously grind, brew, and present
        each cup with a level of care that transcends the ordinary. It's not
        just about caffeine; it's about creating an experience that tantalizes
        the taste buds and captivates the senses.
      </p>
      <h3>Quality Beyond Coffee Beans</h3>
      <p>
        Our devotion to quality extends beyond the beans themselves. Every
        ingredient in our menu is chosen with the same discernment, ensuring
        that each sip and bite embodies our commitment to excellence. Whether
        it's the perfectly frothed milk in your latte or the artisanal
        pastries on the counter, every detail matters.
      </p>
      <h3>A Haven for Connection</h3>
      <p>
        Coffee Blend isn't just a coffee shop; it's a haven for connection. We
        believe in fostering a sense of community, providing a space where
        conversations flow as freely as the coffee. Friends, families, and
        individuals alike find solace in our cozy ambiance, making every visit
        an opportunity to share stories, laughter, and create lasting
        memories.
      </p>
      <p>
        As you step into Coffee Blend, you're not just stepping into a coffee
        shop; you're stepping into an experience—a celebration of
        craftsmanship, dedication, and the simple joy found in a perfectly
        brewed cup of coffee.
      </p>
      <div class="main_btn">
        <a href="index.html">Return Home<i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </section>

  <section class="feedback_main">
    <h2>Leave Feedback</h2>
    <form id="feedbackForm" action="#" method="post">
      <div class="form-group">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div class="form-group">
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="message">Your Feedback:</label>
        <textarea id="message" name="message" rows="4" required></textarea>
      </div>
      <div class="form-group">
        <button type="submit">Submit Feedback</button>
      </div>
    </form>
  </section>

  <footer>
    <div class="footer_main">
      <div class="footer_tag">
        <h2>Location</h2>
        <p>Lebanon</p>
        <p>USA</p>
        <p>India</p>
        <p>Japan</p>
        <p>Italy</p>
      </div>

      <div class="footer_tag">
        <h2>Quick Link</h2>
        <p><a href="index.html#Home">Home</a></p>
        <p><a href="index.html#About">About</a></p>
        <p><a href="index.html#Menu">Menu</a></p>
        <p><a href="index.html#Review">Review</a></p>
        <p><a href="index.html#team">Team</a></p>
      </div>

      <div class="footer_tag">
        <h2>Contact</h2>
        <p>+94 12 3456 789</p>
        <p>+94 25 5568456</p>
        <p>coffeeBlend@gmail.com</p>
      </div>

      <div class="footer_tag">
        <h2>Our Service</h2>
        <p>Fast Delivery</p>
        <p>Easy Payments</p>
        <p>24 x 7 Service</p>
      </div>

      <div class="footer_tag">
        <h2>Follows</h2>
        <a href="https://www.facebook.com/profile.php?id=61553652104374"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/coffeeblendd2023/"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <div class="end">
      <span>Copyright © 2023 Coffee Blend</span>
    </div>
  </footer>
</body>

</html>
