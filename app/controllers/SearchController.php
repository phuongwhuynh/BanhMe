<?php
require_once "../models/Menu.php";

if (isset($_GET['q'])) {
    $results = Order::search($_GET['q']);
    foreach ($results as $item) {
        echo "<p>" . htmlspecialchars($item) . "</p>";
    }
}
?>
