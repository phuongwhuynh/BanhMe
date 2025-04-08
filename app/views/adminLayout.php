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
<style>
body {
  display: flex;
  flex-direction: row; 
  height: 100vh;
  width: 100vw; 
  font-family: 'Trebuchet MS', sans-serif;
  background-color: var(--brown1);   
  color: var(--brown3);
  margin: 0;
  padding: 0;
  overflow-x: hidden;
  overflow-y: hidden;
}
main {
  flex:1;
  display: flex;
  flex-direction: column;
  height: 100vh;
}
.sidebar {
  width: 3.5rem;
  height: 100vh;
  background-color: var(--brown3);
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  width: 100%;
}

.sidebar li {
  display: flex;
  width: 100%;
  justify-content: center;
}

.sidebar a {
  display: flex;                 
  align-items: center;          
  justify-content: center;     
  box-sizing: border-box;

  width: 100%;
  height: 3.5rem;
  color: white;
  font-size: 1.5rem;
  text-decoration: none;
  transition: color 0.2s;
}

.sidebar a:hover {
  color: var(--brown1);
}

.sidebar a.active {
  background-color: var(--brown2);
}

</style>
<nav class="sidebar">
  <ul>
    <li>
      <a href="index.php?page=menuAdmin" class="<?php echo ($page == 'menuAdmin') ? 'active' : ''; ?>" title="Menu">
        <i class="fas fa-table"></i>
      </a>
    </li>
    <li>
      <a href="index.php?page=log" class="<?php echo ($page == 'log') ? 'active' : ''; ?>" title="History">
        <i class="fas fa-receipt"></i>
      </a>
    </li>
    <li>
      <a href="index.php?page=setting" class="<?php echo ($page == 'setting') ? 'active' : ''; ?>" title="Settings">
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
