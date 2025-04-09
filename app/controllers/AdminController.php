<?php
require_once "../app/models/Admin.php";
class AdminController {
    public static function updateMenuItem($data) {
        $itemId = $data['item_id'];
        $name = $data['name'];
        $price = $data['price'];
        $description = $data['description'];
    
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES['image']['tmp_name'];
            $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
            if (!in_array(strtolower($fileExt), $allowedExt)) {
                http_response_code(400);
                echo "Invalid file type.";
                exit;
            }
        
            $response = Admin::updateMenuItem($itemId, $name, $price, $description, $tmpPath, $fileExt);
        } else {
            $response = Admin::updateMenuItem($itemId, $name, $price, $description, null, null);
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public static function createMenuItem($data) {
        $name = $data['name'];
        $price = $data['price'];
        $description = $data['description'];
    
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES['image']['tmp_name'];
            $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
            if (!in_array(strtolower($fileExt), $allowedExt)) {
                http_response_code(400);
                echo "Invalid file type.";
                exit;
            }
        
            // Call model with $tmpPath + extension
            $response = Admin::createMenuItem($name, $price, $description, $tmpPath, $fileExt);
        } else {
            $response = ["success" => False, "message" => "No image input" ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public static function deleteMenuItem($data){
        $itemId=$data['item_id'];
        $response = Admin::deleteMenuItem($itemId);
        header('Content-Type: application/json');
        echo json_encode($response);


    }
}
?>