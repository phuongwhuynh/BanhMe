<?php
require_once __DIR__ . '/../app/controllers/PageController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
PageController::init();
PageController::loadPage($page);
?>
