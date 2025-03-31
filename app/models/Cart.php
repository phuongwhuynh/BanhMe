<?php
require_once "Database.php";

class Cart {
    public static function getAll($user_id){
        $items = [];

        try {
            $db = Database::connect();
            $query = "SELECT  c.item_id,c.quantity, m.name, m.price, m.image_path
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
        } catch (mysqli_sql_exception $e) {
            error_log("Cart::getAll error: " . $e->getMessage());
        }

        return $items;
    }    

    public static function updateCart($user_id,$item_id,$quantity){
        try{
            $db = Database::connect();
            if ($quantity == 0) {
                $query = "DELETE FROM in_cart WHERE user_id=? AND item_id=?";
            } else {
                $query = "UPDATE in_cart SET quantity=? WHERE user_id=? AND item_id=?";
            }
    
            $stmt = $db->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $db->error);
            }
    
            if ($quantity == 0) {
                $stmt->bind_param("ii", $user_id, $item_id);
            } else {
                $stmt->bind_param("iii", $quantity, $user_id, $item_id);
            }
    
            $stmt->execute();
            $affectedRows = $stmt->affected_rows;
            $stmt->close();
            $db->close();
            if ($affectedRows > 0) {
                return ["success" => true];
            }
            else {
                return ["success" => false,  "message" => "No changes made. Item might not exist."];
            }
        }
        catch (mysqli_sql_exception $e) {
            error_log("Cart::updateCart error: " . $e->getMessage());
            return ["success" => false, "message" => "An error occurred. Please try again later."];
        }
    }
}
?>