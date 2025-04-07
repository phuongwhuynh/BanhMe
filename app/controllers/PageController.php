<?php

class PageController {


    public static function loadPage($page) {
        if ($_SESSION['user_role']==='user'){
            self::loadUserView($page);
        }
        else if ($_SESSION['user_role']==='admin'){
            self::loadAdminView($page);
        }
        else {
            self::loadGuestView($page);
        }
    }

    private static function loadGuestView($page) {
        $allowedPages = ["home", "order","contact","login","register"];
        if (!in_array($page, $allowedPages)) {
            require_once "../app/views/404.php";
        }
        else {
            $content =  "../app/views/$page.php";
            require_once "../app/views/layout.php";
        }
    }

    private static function loadUserView($page){
        $allowedPages = ["home", "order","history","contact","cart","orderSuccess"];
        if (!in_array($page, $allowedPages)) {
            require_once "../app/views/404.php";
        }
        else {
            $content =  "../app/views/$page.php";
            require_once "../app/views/layout.php";
        }
    }
    private static function loadAdminView($page){
        /*to do*/
        $allowedPages = ['menuAdmin','log'];
        if (!in_array($page, $allowedPages)) {
            require_once "../app/views/404.php";
        }
        else {
            $content =  "../app/views/$page.php";
            require_once "../app/views/adminLayout.php";
        }
    }
}

?>
