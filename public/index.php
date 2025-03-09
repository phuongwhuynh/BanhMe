<?php

require_once '../app/include/config.php';


if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['ajax']) && $_GET['ajax']==1){
    $controller[$_GET['controller']]::{$_GET['action']}();
}
else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax'])&& $_POST['ajax']==1){
    $controller[$_POST['controller']]::{$_POST['action']}();
}
else {
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    PageController::loadPage($page);
}
?>
