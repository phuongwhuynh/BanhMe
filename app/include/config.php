<?php
require_once "../app/controllers/OrderController.php";
require_once "../app/controllers/PageController.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/CartController.php";

$controller= [
    "order" => "OrderController",
    "page" => "PageController",
    "user" => "UserController",
    "cart" => "CartController"
];

// $action = [
//     "pagination" => "handlePagination",
//     "addCart" => "addCart"
// ];

?>