<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bánh Me! - <?php echo ucfirst($page); ?></title>
  <link rel="stylesheet" href="/mywebsite/public/css/variables.css">
  <link rel="stylesheet" href="/mywebsite/public/css/style.css">

  <?php 
    $cssWebPath = "/mywebsite/public/css/$page.css"; 
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cssWebPath)) : ?>
      <link rel="stylesheet" href="<?php echo $cssWebPath; ?>">
  <?php endif; ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <header>
    <div class="logo-container">
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
    <div class="login-container">
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
