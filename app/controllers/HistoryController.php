<?php
require_once "../app/models/HIstory.php";
class HistoryController {

    public static function showHistory(){
        $items=Cart::getAll($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($items);
    }

}
?>