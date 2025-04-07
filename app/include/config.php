<?php
require_once "../app/controllers/OrderController.php";
require_once "../app/controllers/PageController.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/CartController.php";
require_once "../app/controllers/HistoryController.php";

$controller= [
    "order" => "OrderController",
    "page" => "PageController",
    "user" => "UserController",
    "cart" => "CartController",
    "history"=>"HistoryController"
];

// $action = [
//     "pagination" => "handlePagination",
//     "addCart" => "addCart"
// ];

?>