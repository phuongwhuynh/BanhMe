<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bánh Me! - <?php echo ucfirst($page); ?></title>
  <link rel="stylesheet" href="public/css/variables.css">
  <link rel="stylesheet" href="public/css/style.css">

  <?php 
    $cssWebPath = "public/css/$page.css"; 
  ?>
  <link rel="stylesheet" href="<?php echo $cssWebPath; ?>">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <header>
    <div class="left-header">
      <a href="index.php?page=home" class="logo">Bánh Me!</a>
    </div>
    <nav>
      <ul>
      <li><a href="index.php?page=home" class="navbar-button <?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a></li>
      <li><a href="index.php?page=order" class="navbar-button <?php echo ($page == 'order') ? 'active' : ''; ?>">Order</a></li>
      <li><a href="index.php?page=activity" class="navbar-button <?php echo ($page == 'activity') ? 'active' : ''; ?>">Activity</a></li>
      <li><a href="index.php?page=history" class="navbar-button <?php echo ($page == 'history') ? 'active' : ''; ?>">History</a></li>
      </ul>
    </nav>
    <div class="right-header"> 
        <a href="index.php?page=home">
          <img class="cart-image" src="public/images/cart.png">
        </a>
        <a href="index.php?page=home" class="login-button">Login</a>
    </div>
  </header>

  <main>
      <?php include($content); ?>
  </main>

  <footer>
    <p>&copy; 2025 Bánh Me! All Rights Reserved.</p>
  </footer>
</body>
</html>

