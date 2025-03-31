<?php
require_once "../app/models/Cart.php";
class CartController {

    public static function getAll(){
        $items=Cart::getAll($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($items);
    }
    public static function updateQuantity(){
        $item_id=$_POST['item_id'];
        $quantity=$_POST['quantity'];
        $response=Cart::updateCart($_SESSION['user_id'],$item_id, $quantity);
        header('Content-Type: application/json');
        echo json_encode($response);

    }

}
?>