<?php
require_once "../app/models/User.php";
class LoginController {
    public static function loginAttempt() {
        $username=$_POST["username"];
        $password=$_POST["password"];
        $response=User::authenticate($username,$password);
        header('Content-Type: application/json');
        echo json_encode($response);

    }
    public static function logout() {
        session_unset(); 
        session_destroy(); 
        echo json_encode(["success" => true]); 
    }
    public static function signUp() {

    }
}
?>