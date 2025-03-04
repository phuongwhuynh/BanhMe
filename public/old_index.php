<?php
/* 

include __DIR__ . '/includes/config.php'; 

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$allowed_pages = ['home', 'about', 'services', 'contact'];

if (in_array($page, $allowed_pages)) {
    $content = "pages/$page.php";
    $cssFile = "css/$page.css"; 
} else {
    $content = "pages/404.php";
    $cssFile = "css/404.css"; 
} 
*/
require_once "../app/controllers/PageController.php";

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
PageController::loadPage($page);

?> 


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bánh Me! - <?php echo ucfirst($page); ?></title>
  <link rel="stylesheet" href="css/variables.css">
  <link rel="stylesheet" href="css/style.css"> 
  <?php if (file_exists($cssFile)) : ?> 
      <link rel="stylesheet" href="<?php echo $cssFile; ?>">
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
      <li><a href="index.php?page=about" class="navbar-button <?php echo ($page == 'about') ? 'active' : ''; ?>">About</a></li>
      <li><a href="index.php?page=services" class="navbar-button <?php echo ($page == 'services') ? 'active' : ''; ?>">Services</a></li>
      <li><a href="index.php?page=contact" class="navbar-button <?php echo ($page == 'contact') ? 'active' : ''; ?>">Contact</a></li>
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
    <p>&copy; 2025 My Website. All Rights Reserved.</p>
  </footer>

</body>
</html>
