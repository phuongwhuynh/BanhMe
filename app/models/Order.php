<?php
require_once "Database.php";

class Order {
    public static function search($query) {
        $db = Database::connect();
        $query = $db->real_escape_string($query);
        $result = $db->query("SELECT name FROM menu WHERE name LIKE '%$query%' LIMIT 5");

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row['name'];
        }
        return $items;
    }
    public static function getAll(){
        $db=Database::connect();
        $result=$db->query("SELECT * FROM menu");
        $items=[];
        while ($row=$result->fetch_assoc()) {
            $items[]=$row;
        }
        return $items;
    }
    public static function getPaginated($page, $limit, $sort, $categories) {
        $db = Database::connect();
        $offset = ($page - 1) * $limit;


        // Default sorting
        $orderBy = "name ASC"; 
        $inCate="";
        if (!empty($categories)){
            $inCate="cate IN (" . implode(',',array_map(fn($x) => "'$x'",$categories)) . ")" ;
        }
        else {
            $inCate="1=0";
        }

        // Sorting conditions
        if ($sort === "name_desc") {
            $orderBy = "name DESC";
        } elseif ($sort === "price_asc") {
            $orderBy = "price ASC";
        } elseif ($sort === "price_desc") {
            $orderBy = "price DESC";
        }
    
        $stmt = $db->prepare("SELECT * FROM menu WHERE $inCate ORDER BY $orderBy LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
            
        }
    
        return $items;
    }
    
    public static function countAll($categories = []) {
        $db = Database::connect();
        $query = "SELECT COUNT(*) as total FROM menu";
    
        if (!empty($categories)) {
            $placeholders = implode(",", array_fill(0, count($categories), "?"));
            $query .= " WHERE cate IN ($placeholders)";
        }
    
        $stmt = $db->prepare($query);
    
        if (!empty($categories)) {
            $stmt->bind_param(str_repeat("s", count($categories)), ...$categories);
        }
    
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        return $result['total'] ?? 0; // Return the total count
    }
    
    public static function addCart($user_id, $item_id, $quantity) {
        try {
            $db = Database::connect();
            $old_quantity=null;
            // check if item already exists in the user's cart
            $stmt = $db->prepare("SELECT quantity FROM in_cart WHERE user_id = ? AND item_id = ?");
            $stmt->bind_param("ii", $user_id, $item_id); // Bind parameters (string, integer)
            $stmt->execute();
            $stmt->bind_result($old_quantity);
            $stmt->fetch();
            $stmt->close();
                            
            if ($old_quantity !== null) {
                $newQuantity = $old_quantity + $quantity;
                $stmt = $db->prepare("UPDATE in_cart SET quantity = ? WHERE user_id = ? AND item_id = ?");
                $stmt->execute([$newQuantity, $user_id, $item_id]);
            } else {
                $stmt = $db->prepare("INSERT INTO in_cart (user_id, item_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $item_id, $quantity]);
            }
    
            return ["success" => true];
        } catch (PDOException $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
        
    }
}
?>
