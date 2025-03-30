<?php
require_once "../app/models/Cart.php";
class CartController {

    public static function getAll(){
        $items=Cart::getAll($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($items);
    }
    public static function updateQuantity(){
        
    }
    public static function deleteItem(){

    }
}
?>