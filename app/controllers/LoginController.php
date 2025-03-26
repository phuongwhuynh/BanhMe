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
}
?>