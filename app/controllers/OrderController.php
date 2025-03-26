<?php
require_once "../app/models/Order.php";

class OrderController {
    public static function index() {
        return Order::getAll();
    }
    public static function countOrders() {
        return Order::countAll();
    }
    public static function getPaginated($page =1, $limit=6, $sort, $categories) {
        return Order:: getPaginated($page,$limit,$sort, $categories);
    }
    public static function handlePagination() {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
        $page = isset($_GET['pageNum']) ? (int)$_GET['pageNum'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : "name_asc";
        $categories=isset($_GET['categories']) ?explode(",", $_GET["categories"]) : [];

        $orders = self::getPaginated($page, $limit, $sort, $categories);
        $totalProducts = self::countOrders();
        $totalPages = ceil($totalProducts / $limit);
    
        header('Content-Type: application/json');
        echo json_encode([
            'products' => $orders,
            'totalPages' => $totalPages
        ]);
    }
    public static function addCart() {
        $username=$_SESSION["user"];
        $quantity=$_POST["quantity"];
        $item_id=$_POST["item_id"];
        $response=Order::addCart($username, $item_id, $quantity);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
