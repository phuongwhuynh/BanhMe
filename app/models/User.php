<?php
require_once "Database.php";
class User {
    static public function authenticate($username,$password) {
        try {
            $db = Database::connect();
            $query = "SELECT user_id, password_hash,role FROM accounts WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);  // 's' for string
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            if ($user && $password==$user['password_hash'] /*password_verify($password, $user['password_hash'])*/) {
                $_SESSION['user_role'] = $user['role']; 
                $_SESSION['user_id']=$user['user_id'];
                return ["success" => true];
            } else {
                return ["success" => false, "message" => "Incorrect username or password!"];
            }
        }
        catch (PDOException $e){
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
?>