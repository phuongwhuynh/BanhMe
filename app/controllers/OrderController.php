<?php
require_once dirname(__DIR__) . "/models/Order.php";

class OrderController {
    public static function index() {
        return Order::getAll();
    }
    public static function countOrders() {
        return Order::countAll();
    }
    public static function getPaginated($page =1, $limit=6, $sort) {
        return Order:: getPaginated($page,$limit,$sort);
    }
    public static function handlePagination() {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        $page = isset($_GET['pageNum']) ? (int)$_GET['pageNum'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : "name_asc";

        $orders = self::getPaginated($page, $limit, $sort);
        $totalProducts = self::countOrders();
        $totalPages = ceil($totalProducts / $limit);
    
        header('Content-Type: application/json');
        echo json_encode([
            'products' => $orders,
            'totalPages' => $totalPages
        ]);
    }

}
?>
