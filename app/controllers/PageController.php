<?php

class PageController {


    public static function loadPage($page) {
        if ($_SESSION['user_role']==='user'){
            //to-do
        }
        else if ($_SESSION['user_role']==='admin'){
            //to-do
        }
        else {
            self::loadGuestView($page);
        }
    }

    private static function loadGuestView($page) {
        $allowedPages = ["home", "order","contact","login"];
        if (!in_array($page, $allowedPages)) {
            require_once "../app/views/404.php";
        }
        else {
            $content =  "../app/views/guest/$page.php";
            require_once "../app/views/guest/layout.php";
        }
    }

    private static function loadUserView($page){
        /*to do*/
    }
    private static function loadAdminView($page){
        /*to do*/

    }
}

?>
