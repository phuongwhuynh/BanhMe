<?php
require_once "Database.php";

class History {
    public static function getHistory($user_id, $limit, $offset) {
        $db = Database::connect();
    
        try {
            // Query to get orders for the user with a limit and offset on orders only
            $stmt = $db->prepare("
                SELECT 
                    oi.order_id, 
                    t.total_price, 
                    t.created_at, 
                    oi.item_id, 
                    i.name AS item_name, 
                    i.image_path, 
                    i.price, 
                    oi.quantity
                FROM  
                    (SELECT 
                        o.order_id, 
                        o.total_price, 
                        o.created_at
                    FROM orders o
                    WHERE o.user_id = ?
                    ORDER BY o.created_at DESC
                    LIMIT ? OFFSET ?) t 
                JOIN orders_include_items oi ON t.order_id = oi.order_id 
                JOIN menu i ON oi.item_id = i.item_id
            ");
    
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $db->error);
            }
    
            $stmt->bind_param("iii", $user_id, $limit, $offset);
    
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
    
            $result = $stmt->get_result();
            $history = [];
    
            // Loop through the result and organize data by order_id
            while ($row = $result->fetch_assoc()) {
                $order_id = $row['order_id'];
    
                // If the order isn't already in the history array, initialize it
                if (!isset($history[$order_id])) {
                    $history[$order_id] = [
                        'order_id' => $order_id,
                        'datetime' => $row['created_at'],
                        'total_price' => $row['total_price'],
                        'items' => [] // Initialize items for this order
                    ];
                }
    
                // Add the current item to the appropriate order's items array
                $history[$order_id]['items'][] = [
                    'item_id' => $row['item_id'],
                    'name' => $row['item_name'],
                    'image' => $row['image_path'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity']
                ];
            }
    
            // Return a response with the history of orders
            return [
                'success' => true,
                'history' => array_values($history) // Reset numeric keys for the orders
            ];
    
        } catch (mysqli_sql_exception $e) {
            error_log("Error in getHistory(): " . $e->getMessage());
    
            return [
                'success' => false,
                'message' => "Failed to load history. Please try again later."
            ];
        }
    }
    public static function getAllHistory($limit, $offset) {
        $db = Database::connect();
    
        try {
            // Query to get orders for the user with a limit and offset on orders only
            $stmt = $db->prepare("
                SELECT 
                    oi.order_id, 
                    t.total_price, 
                    t.created_at, 
                    oi.item_id, 
                    i.name AS item_name, 
                    i.image_path, 
                    i.price, 
                    oi.quantity
                FROM  
                    (SELECT 
                        o.order_id, 
                        o.total_price, 
                        o.created_at
                    FROM orders o
                    ORDER BY o.created_at DESC
                    LIMIT ? OFFSET ?) t 
                JOIN orders_include_items oi ON t.order_id = oi.order_id 
                JOIN menu i ON oi.item_id = i.item_id
            ");
    
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $db->error);
            }
    
            $stmt->bind_param("ii", $limit, $offset);
    
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
    
            $result = $stmt->get_result();
            $history = [];
    
            // Loop through the result and organize data by order_id
            while ($row = $result->fetch_assoc()) {
                $order_id = $row['order_id'];
    
                // If the order isn't already in the history array, initialize it
                if (!isset($history[$order_id])) {
                    $history[$order_id] = [
                        'order_id' => $order_id,
                        'datetime' => $row['created_at'],
                        'total_price' => $row['total_price'],
                        'items' => [] // Initialize items for this order
                    ];
                }
    
                // Add the current item to the appropriate order's items array
                $history[$order_id]['items'][] = [
                    'item_id' => $row['item_id'],
                    'name' => $row['item_name'],
                    'image' => $row['image_path'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity']
                ];
            }
    
            // Return a response with the history of orders
            return [
                'success' => true,
                'history' => array_values($history) // Reset numeric keys for the orders
            ];
    
        } catch (mysqli_sql_exception $e) {
            error_log("Error in getHistory(): " . $e->getMessage());
    
            return [
                'success' => false,
                'message' => "Failed to load history. Please try again later."
            ];
        }
    }

}
?>