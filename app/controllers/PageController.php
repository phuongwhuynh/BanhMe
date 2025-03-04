<?php

require_once dirname(__DIR__) . "/controllers/OrderController.php"; 

class PageController {
    private static $orderController;

    public static function init() {
        self::$orderController = new OrderController();
    }

    public static function loadPage($page) {
        $allowedPages = ["home", "order", "activity", "history"];
        $data = []; 

        if (!in_array($page, $allowedPages)) {
            $page = "404";
        }

        if ($page === "order" && isset($_GET['ajax'])) {
            self::$orderController->handlePagination();
            exit;
        }

        // if ($page === "order") {
        //     $totalProducts = self::$orderController->countOrders();
        //     $data['totalProducts']=$totalProducts;
        //     $data['totalPages']=ceil($totalProducts/6);
        // }

        self::loadView($page, $data);
    }

    private static function loadView($page, $data = []) {
        extract($data); 
        $content = dirname(__DIR__) . "/views/$page.php";
        require_once dirname(__DIR__) . "/views/layout.php";
    }

    
}

?>
