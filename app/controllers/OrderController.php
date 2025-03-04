<?php
require_once dirname(__DIR__) . "/models/Order.php";

class OrderController {
    public function index() {
        return Order::getAll();
    }
    public function countOrders() {
        return Order::countAll();
    }
    public function getPaginated($page =1, $limit=12, $sort) {
        return Order:: getPaginated($page,$limit,$sort);
    }
    public function handlePagination() {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
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
