<?php
class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            self::$connection = new mysqli("localhost", "root", "banhmi", "banh_mi_db");
            if (self::$connection->connect_error) {
                die("Database Connection Failed: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }
}
?>
