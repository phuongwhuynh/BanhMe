<?php
require_once "../app/models/Order.php";

class OrderController {
    // public static function index() {
    //     return Order::getAll();
    // }

    public static function handlePagination() {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
        $page = isset($_GET['pageNum']) ? (int)$_GET['pageNum'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : "name_asc";
        $categories=isset($_GET['categories']) ?explode(",", $_GET["categories"]) : [];
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

        $orders = Order::getPaginated($page, $limit, $sort, $categories, $searchTerm);
        $totalProducts = Order::countAll($categories, $searchTerm);

        $totalPages = ceil($totalProducts / $limit);
    
        header('Content-Type: application/json');
        echo json_encode([
            'products' => $orders,
            'totalPages' => $totalPages
        ]);
    }
    public static function addCart($data) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
            echo json_encode(["success" => false, "message" => "Unauthorized"]);
            exit();
        }

        $username=$_SESSION["user_id"];
        $quantity=$data["quantity"];
        $item_id=$data["item_id"];
        $response=Order::addCart($username, $item_id, $quantity);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
