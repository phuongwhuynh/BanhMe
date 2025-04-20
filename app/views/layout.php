<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bánh Me! - <?php echo ucfirst($page); ?></title>
  <link rel="stylesheet" href="public/css/variables.css">
  <link rel="stylesheet" href="public/css/style.css">

  <?php 
    $cssWebPath = "public/css/$page.css"; 
    $jsPath="public/js/$page.js";
  ?>
  <link rel="stylesheet" href="<?php echo $cssWebPath; ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="public/js/main.js" defer></script>
  <script src="<?php echo $jsPath?>" defer></script>


</head>
<body data-user-role="<?= $_SESSION['user_role'] ?? '' ?>">
  <header>
    <div class="left-header">
      <a href="index.php?page=home" class="logo">Bánh Me!</a>

    </div>
    <nav>
      <ul>
      <li><a href="index.php?page=home" class="navbar-button <?php echo ($page == 'home') ? 'active' : ''; ?>">Trang chủ</a></li>
      <li><a href="index.php?page=order" class="navbar-button <?php echo ($page == 'order') ? 'active' : ''; ?>">Thực đơn </a></li>
      <?php if ($_SESSION['user_role']==="user"): ?>
        <li><a href="index.php?page=history" class="navbar-button <?php echo ($page == 'history') ? 'active' : ''; ?>">Lịch sử </a></li>
      <?php endif; ?>
      <li><a href="index.php?page=contact" class="navbar-button <?php echo ($page == 'contact') ? 'active' : ''; ?>">Liên hệ</a></li>

      </ul>
    </nav>
    <div class="right-header"> 
        <?php if ($_SESSION['user_role']==="user"): ?>
          <a href="index.php?page=cart">
            <img class="cart-image" src="public/images/cart.png">
          </a>
          <div class="profile-container">
            <div class="profile-icon" onclick="toggleDropdown()">
              <?= strtoupper($_SESSION['username'][0]); ?> 
            </div>
            <div class="dropdown-menu" id="dropdown-menu">
              <p>Xin chào, <?= $_SESSION['username']; ?>!</p>
              <button class="dropdown-btn" onclick="logout()">Đăng xuất</button>
            </div>
          </div>
      <?php else: ?>
        <a href="index.php?page=login" class="login-button">Đăng nhập</a>
      <?php endif; ?>
      <div class="hamburger" onclick="toggleNavbar()">
        ☰
      </div>
    </div>
  </header>
  <main>
  <?php include($content); ?>
  </main>
  </div>
  <footer>
    &copy; 2025 Bánh Me! All Rights Reserved.
  </footer>
  <div id="notification-popup">
    <div class="notification-content"></div>
  </div>


</body>


</html>

