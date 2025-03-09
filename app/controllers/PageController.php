<?php

require_once dirname(__DIR__) . "/controllers/OrderController.php"; 

class PageController {
    // public static $orderController;

    // public static function init() {
    //     self::$orderController = new OrderController();
    // }

    public static function loadPage($page) {
        $allowedPages = ["home", "order", "activity", "history"];
        // $data = []; 

        if (!in_array($page, $allowedPages)) {
            $page = "404";
        }

        // if ($page === "order" && isset($_GET['ajax'])) {
        //     self::$orderController->handlePagination();
        //     exit;
        // }

        // if ($page === "order") {
        //     $totalProducts = self::$orderController->countOrders();
        //     $data['totalProducts']=$totalProducts;
        //     $data['totalPages']=ceil($totalProducts/6);
        // }

        self::loadView($page);
    }

    private static function loadView($page) {
        // extract($data); 
        $content =  "../app/views/$page.php";
        require_once "../app/views/layout.php";
    }

    
}

?>
