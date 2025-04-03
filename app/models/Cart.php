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
    public static function submitOrder($user_id,$itemList){
        try {
            $db=Database::connect();
            $db->begin_transaction();
            $orderStmt = $db->prepare("INSERT INTO orders (user_id) VALUES (?)");
            $orderStmt->bind_param("i", $user_id);
            $orderStmt->execute();
            $order_id = $db->insert_id;
            $orderStmt->close();
            $itemStmt = $db->prepare("INSERT INTO orders_include_items (order_id, item_id, quantity) VALUES (?, ?, ?)");

            foreach ($itemList as $item) {
                if ($item['quantity'] <= 0) {
                    throw new Exception("Invalid quantity for item ID: " . $item['item_id']);
                }
                $itemStmt->bind_param("iii", $order_id, $item['item_id'], $item['quantity']);
                if (!$itemStmt->execute()) {
                    throw new Exception("Failed to insert order item: " . $itemStmt->error);
                }
            }
            $itemStmt->close();
            $db->commit();
            return [
                'success' => true
            ];
    

        }
        catch (mysqli_sql_exception $e) {
            if ($db && method_exists($db, 'rollback')) {
                $db->rollback();
            }    
            error_log("Cart:submitOrder error: " . $e->getMessage());
            return ["success" => false, "message" => "An error occurred. Please try again later."];
        }
    }
}
?>