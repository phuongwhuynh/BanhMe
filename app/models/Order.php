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
    
    // public static function getPaginated($page, $limit, $sort, $categories) {
    //     $db = Database::connect();
    //     $offset = ($page - 1) * $limit;


    //     // Default sorting
    //     $orderBy = "name ASC"; 
    //     $inCate="";
    //     if (!empty($categories)){
    //         $inCate="cate IN (" . implode(',',array_map(fn($x) => "'$x'",$categories)) . ")" ;
    //     }
    //     else {
    //         $inCate="1=0";
    //     }

    //     // Sorting conditions
    //     if ($sort === "name_desc") {
    //         $orderBy = "name DESC";
    //     } elseif ($sort === "price_asc") {
    //         $orderBy = "price ASC";
    //     } elseif ($sort === "price_desc") {
    //         $orderBy = "price DESC";
    //     }
    
    //     $stmt = $db->prepare("SELECT * FROM menu WHERE $inCate ORDER BY $orderBy LIMIT ?, ?");
    //     $stmt->bind_param("ii", $offset, $limit);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    
    //     $items = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $items[] = $row;
            
    //     }
    
    //     return $items;
    // }
    
    // public static function countAll($categories = []) {
    //     if (empty($categories)){
    //         return 0;
    //     }
    //     $db = Database::connect();
    //     $query = "SELECT COUNT(*) as total FROM menu";
    
    //     $placeholders = implode(",", array_fill(0, count($categories), "?"));
    //     $query .= " WHERE cate IN ($placeholders)";
        
    
    //     $stmt = $db->prepare($query);
    //     $stmt->bind_param(str_repeat("s", count($categories)), ...$categories);
        
    
    //     $stmt->execute();
    //     $result = $stmt->get_result()->fetch_assoc();
    
    //     return $result['total'] ?? 0; // Return the total count
    // }
    public static function getPaginated($page, $limit, $sort, $categories, $searchTerm = '') {
        $db = Database::connect();
        $offset = ($page - 1) * $limit;
    
        // Default sorting
        $orderBy = "name ASC";
        $inCate = "";
        
        if (!empty($categories)) {
            $inCate = "cate IN (" . implode(',', array_map(fn($x) => "'$x'", $categories)) . ")";
        } else {
            $inCate = "1=0";
        }
    
        // Add search condition
        $searchCondition = '';
        if (!empty($searchTerm)) {
            $searchCondition = " AND name LIKE ?"; 
        }
    
        // Sorting conditions
        if ($sort === "name_desc") {
            $orderBy = "name DESC";
        } elseif ($sort === "price_asc") {
            $orderBy = "price ASC";
        } elseif ($sort === "price_desc") {
            $orderBy = "price DESC";
        }
    
        $query = "SELECT * FROM menu WHERE $inCate $searchCondition ORDER BY $orderBy LIMIT ?, ?";
        $stmt = $db->prepare($query);
    
        // Prepare parameter types
        $types = ""; // For categories
        if (!empty($searchTerm)) {
            $searchTerm = "%$searchTerm%";
            $types .= "s"; // For the search term
            $stmt->bind_param($types . "ii", $searchTerm, $offset, $limit);
        }
        else {
            $stmt->bind_param("ii", $offset, $limit);

        }
    
        // Bind parameters using the correct method
        // Use argument unpacking for categories, followed by searchTerm, offset, and limit

    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    
        return $items;
    }

    public static function countAll($categories = [], $searchTerm = '') {
        $db = Database::connect();
        
        if (empty($categories)) {
            return 0;
        }
    
        // Base query
        $query = "SELECT COUNT(*) as total FROM menu WHERE cate IN (" . implode(",", array_fill(0, count($categories), "?")) . ")";
    
        // Add search condition if a search term is provided
        if (!empty($searchTerm)) {
            $query .= " AND name LIKE ?";
        }
    
        $stmt = $db->prepare($query);
    
        // Prepare parameter types
        $types = str_repeat("s", count($categories)); // For categories
    
        if (!empty($searchTerm)) {
            $searchTerm = "%$searchTerm%";
            $types .= "s"; // For the search term
        }
    
        // Bind parameters using the correct method
        // The first parameters are the categories, followed by the search term if it exists
        if (!empty($searchTerm)) {
            $stmt->bind_param($types, ...array_merge($categories, [$searchTerm]));
        } else {
            $stmt->bind_param($types, ...$categories);
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
            $stmt->bind_param("ii", $user_id, $item_id); 
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
