<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bánh Me! </title>
  <link rel="stylesheet" href="public/css/variables.css">
  <link rel="stylesheet" href="public/css/layoutAdmin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <?php 
    $cssWebPath = "public/css/$page.css"; 
    $jsPath="public/js/$page.js";
  ?>
  <link rel="stylesheet" href="<?php echo $cssWebPath; ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="public/js/main.js" defer></script>
  <script src="<?php echo $jsPath?>" defer></script>


</head>
<body>


<nav class="sidebar">
  <ul>
    <li>
      <a href="index.php?page=menu" class="<?php echo ($page == 'menuAdmin') ? 'active' : ''; ?>" title="Menu">
        <i class="fas fa-table"></i>
      </a>
    </li>
    <li>
      <a href="index.php?page=log" class="<?php echo ($page == 'logAdmin') ? 'active' : ''; ?>" title="History">
        <i class="fas fa-receipt"></i>
      </a>
    </li>
    <li>
      <a href="index.php?page=setting" class="<?php echo ($page == 'settingAdmin') ? 'active' : ''; ?>" title="Settings">
        <i class="fas fa-cog"></i>
      </a>
    </li>
  </ul>
</nav>
<main>
  <?php include($content); ?>
</main>


</body>
</html>
