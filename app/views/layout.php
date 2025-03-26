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

  <style>
        .profile-container {
            position: relative;
            display: inline-block;
        }
        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
            width: 150px;
        }
        .dropdown-menu a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: black;
        }
        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
    </style>
    <script>
        function toggleDropdown() {
            let menu = document.getElementById("dropdown-menu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
        
        function logout() {
            fetch('logout.php', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "index.php?page=home"; // Redirect to home
                    }
                });
        }

        window.onclick = function(event) {
            if (!event.target.closest('.profile-container')) {
                document.getElementById("dropdown-menu").style.display = "none";
            }
        };
    </script>

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
              <?= strtoupper($_SESSION['username'][0]); ?> 
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

