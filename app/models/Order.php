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
    public static function getPaginated($page, $limit, $sort) {
        $db = Database::connect();
        $offset = ($page - 1) * $limit;

    
        // Default sorting
        $orderBy = "name ASC"; 
    
        // Sorting conditions
        if ($sort === "name_desc") {
            $orderBy = "name DESC";
        } elseif ($sort === "price_asc") {
            $orderBy = "price ASC";
        } elseif ($sort === "price_desc") {
            $orderBy = "price DESC";
        }
    
        $stmt = $db->prepare("SELECT * FROM menu ORDER BY $orderBy LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
            
        }
    
        return $items;
    }
    
    public static function countAll() {
        $db = Database::connect();
        $result = $db->query("SELECT COUNT(*) as total FROM menu");
        return $result->fetch_assoc()['total'];
    }

}
?>
