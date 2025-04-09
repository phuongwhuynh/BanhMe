<?php
require_once "Database.php";
class Admin {
    public static function updateMenuItem($itemId, $name, $price, $description, $tmpPath = null, $fileExt = null) {
        $conn = Database::connect(); 
        $itemId = (int)$itemId;
        $name = $conn->real_escape_string($name);
        $price = (float)$price;
        $description = $conn->real_escape_string($description);
    
        // Start transaction
        $conn->begin_transaction();
    
        $uploadPath = null;
        if ($tmpPath && $fileExt) {
            $fileExt = strtolower($fileExt);
            $uploadPath = "images/" . $itemId . "." . $fileExt;
            $safePath = $conn->real_escape_string($uploadPath);
            $query = "UPDATE menu SET name = '$name', price = $price, description = '$description', image_path = '$safePath' WHERE item_id = $itemId";
        } else {
            $query = "UPDATE menu SET name = '$name', price = $price, description = '$description' WHERE item_id = $itemId";
        }
    
        if (!$conn->query($query)) {
            $conn->rollback();
            return [
                "success" => false,
                "message" => "Lỗi khi cập nhật: " . $conn->error
            ];
        }
    
        if ($tmpPath && $uploadPath) {
            if (!move_uploaded_file($tmpPath, $uploadPath)) {
                $conn->rollback();
                return [
                    "success" => false,
                    "message" => "Đã cập nhật cơ sở dữ liệu nhưng không thể lưu hình ảnh. Hủy bỏ thay đổi."
                ];
            }
        }
        $conn->commit();
        return [
            "success" => true,
            "message" => "Cập nhật thành công!"
        ];
    }
    public static function createMenuItem($name, $price, $description, $tmpPath, $fileExt ) {
        $conn = Database::connect(); 
        $name = $conn->real_escape_string($name);
        $price = (float)$price;
        $description = $conn->real_escape_string($description);
    
        $conn->begin_transaction();
    
        // Step 1: Insert item without image
        $query = "INSERT INTO menu (name, price, description) VALUES ('$name', $price, '$description')";
        if (!$conn->query($query)) {
            $conn->rollback();
            return [
                "success" => false,
                "message" => "Lỗi khi thêm món: " . $conn->error
            ];
        }
    
        $itemId = $conn->insert_id;
    

        $fileExt = strtolower($fileExt);
        $uploadPath = "images/" . $itemId . "." . $fileExt;

        $safePath = $conn->real_escape_string($uploadPath);
        $updateQuery = "UPDATE menu SET image_path = '$safePath' WHERE item_id = $itemId";

        if (!$conn->query($updateQuery)) {
            $conn->rollback();
            return [
                "success" => false,
                "message" => "Thêm thành công nhưng lỗi khi lưu đường dẫn hình ảnh: " . $conn->error
            ];
        }

        if (!move_uploaded_file($tmpPath, $uploadPath)) {
            $conn->rollback();
            return [
                "success" => false,
                "message" => "Thêm thành công nhưng không thể lưu hình ảnh. Hủy bỏ thay đổi."
            ];
        }
        
    
        $conn->commit();
        return [
            "success" => true,
            "message" => "Thêm món thành công!",
            "item_id" => $itemId
        ];
    }
    public static function deleteMenuItem($itemId) {
        $conn = Database::connect();
        $itemId = (int)$itemId;
    
        $query = "UPDATE menu SET status = 'delete' WHERE item_id = $itemId";
    
        if (!$conn->query($query)) {
            return [
                "success" => false,
                "message" => "Lỗi khi xóa: " . $conn->error
            ];
        }
    
        return [
            "success" => true,
            "message" => "Xóa món thành công!"
        ];
    }
    
}
?>