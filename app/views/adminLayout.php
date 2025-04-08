<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bánh Me! </title>
  <link rel="stylesheet" href="public/css/variables.css">
  <link rel="stylesheet" href="public/css/adminLayout.css">
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
      <a href="index.php?page=menuAdmin" class="navbar-button <?php echo ($page == 'menuAdmin') ? 'active' : ''; ?>" title="Menu">
        <i class="fas fa-table"></i>
      </a>
    </li>
    <li>
      <a href="index.php?page=log" class="navbar-button <?php echo ($page == 'log') ? 'active' : ''; ?>" title="History">
        <i class="fas fa-receipt"></i>
      </a>
    </li>
    <li>
      <a href="index.php?page=setting" title="Settings">
        <i class="fas fa-cog"></i>
      </a>
    </li>
  </ul>
</nav>


<style>
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 3.5rem;
  height: 100vh;
  background-color: var(--brown3);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 1rem;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.sidebar li {
  display: flex;
  justify-content: center;
}

.sidebar a {
  color: white;
  font-size: 1.5rem;
  text-decoration: none;
  transition: color 0.2s;
}

.sidebar a:hover {
  color: var(--brown1);
}

.navbar-button:active {
  background-color: var(--brown1);
}

</style>
</body>
</html>
