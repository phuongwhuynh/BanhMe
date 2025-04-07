<?php
require_once "../app/models/History.php";
class HistoryController {

    public static function showHistory($data){
        if (!$data || !isset($data['limit']) || !isset($data['offset'])) {
            echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
            return;
        }
        $userId = $_SESSION['user_id'] ?? null;
    
        if (!$userId) {
            echo json_encode(["success" => false, "message" => "User not authenticated"]);
            return;
        }

        $response= History::getHistory($userId,$data['limit'],$data['offset']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
?>