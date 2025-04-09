<?php
require_once "../app/controllers/OrderController.php";
require_once "../app/controllers/PageController.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/CartController.php";
require_once "../app/controllers/HistoryController.php";
require_once "../app/controllers/AdminController.php";

$controller= [
    "order" => "OrderController",
    "page" => "PageController",
    "user" => "UserController",
    "cart" => "CartController",
    "history"=>"HistoryController",
    "admin" => "AdminController"
];

// $action = [
//     "pagination" => "handlePagination",
//     "addCart" => "addCart"
// ];

?>