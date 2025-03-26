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
  <script src="<?php echo $jsPath?>" defer></script>
</head>
<body>
  <header>
    <div class="left-header">
      <a href="index.php?page=home" class="logo">Bánh Me!</a>
    </div>
    <nav>
      <ul>
      <li><a href="index.php?page=home" class="navbar-button <?php echo ($page == 'home') ? 'active' : ''; ?>">Trang chủ</a></li>
      <li><a href="index.php?page=order" class="navbar-button <?php echo ($page == 'order') ? 'active' : ''; ?>">Đặt hàng </a></li>
      <?php if ($_SESSION['user_role']==="user"): ?>
        <li><a href="index.php?page=history" class="navbar-button <?php echo ($page == 'history') ? 'active' : ''; ?>">Lịch sử </a></li>
      <?php endif; ?>
      <li><a href="index.php?page=contact" class="navbar-button <?php echo ($page == 'contact') ? 'active' : ''; ?>">Liên lạc</a></li>

      </ul>
    </nav>
    <div class="right-header"> 
        <?php if ($_SESSION['user_role']==="user"): ?>
          <a href="index.php?page=home">
            <img class="cart-image" src="public/images/cart.png">
          </a>
          <div class="profile-container">
            <div class="profile-icon" onclick="toggleDropdown()">
              <?= strtoupper($_SESSION['username'][0]); ?> First letter as icon
            </div>
            <div class="dropdown-menu" id="dropdown-menu">
              <p>Xin chào, <?= $_SESSION['username']; ?>!</p>
              <a href="#" onclick="logout()">Đăng xuất</a>
            </div>
          </div>
      <?php else: ?>
        <a href="index.php?page=login" class="login-button">Đăng nhập</a>
      <?php endif; ?>
    </div>
  </header>
  <div class="content-container">
  <?php include($content); ?>
  </div>

</body>
</html>

