<?php

require_once '../app/controllers/PageController.php';
require_once '../app/controllers/OrderController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page === "order" && isset($_GET['ajax'])) {
    OrderController::handlePagination();
    exit;
}
else if (isset($_POST['controller'])){
    
}

PageController::loadPage($page);
?>
