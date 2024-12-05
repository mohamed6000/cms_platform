<?php

$route = "/";
if(isset($_SERVER["PATH_INFO"])) {
    $route = $_SERVER["PATH_INFO"];
}

// bootstraping
include "core/bootstrap.php";


// routes
if (($route == "/") || ($route == "/home")) {
    include $template."home.php";
} else if ($route == "/login") {
    include $template."login.php";
} else if ($route == "/register") {
    include $template."register.php";
} else if ($route == "/profile") {
    include $template."profile.php";
} else if ($route == "/change-password") {
    include $template."change-password.php";
} else if ($route == "/account-deactivation") {
    include $template."account-deactivation.php";
} else if ($route == "/notifications") {
    include $template."notifications.php";
} else if ($route == "/product") {
    include $template."product.php";
} else if ($route == "/shop") {
    include $template."shop.php";
} else if ($route == "/basket") {
    include $template."basket.php";
} else if ($route == "/checkout") {
    include $template."checkout.php";
} else if ($route == "/bills") {
    include $template."bills.php";
} else if ($route == "/bill") {
    include $template."bill.php";
}

?>