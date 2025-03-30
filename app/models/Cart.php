<?php
require_once "Database.php";

class Cart {
    public static function getAll($user_id){
        $items = [];

        try {
            $db = Database::connect();
            $query = "SELECT c.quantity, m.name, m.price, m.image_path
                      FROM in_cart c 
                      JOIN menu m ON c.item_id = m.item_id
                      WHERE c.user_id = ?";
            
            $stmt = $db->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare statement");
            }

            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            error_log("Cart::getAll error: " . $e->getMessage());
        }

        return $items;
    }    
}
?>