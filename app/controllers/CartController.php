<?php
require_once "../app/models/Cart.php";
class CartController {

    public static function getAll(){
        $items=Cart::getAll($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($items);
    }
    public static function updateQuantity($data){
        $item_id=$data['item_id'];
        $quantity=$data['quantity'];
        $response=Cart::updateCart($_SESSION['user_id'],$item_id, $quantity);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public static function submitOrder($data) {
    
        if (!$data || !isset($data['dataList'])) {
            echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
            return;
        }
    
        $itemList = $data['dataList'];
        $userId = $_SESSION['user_id'] ?? null;
    
        if (!$userId) {
            echo json_encode(["success" => false, "message" => "User not authenticated"]);
            return;
        }
    
        // Process the order
        $response = Cart::submitOrder($userId, $itemList);
    
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    

}
?>