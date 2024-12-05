<?php

$route = "/";
if(isset($_SERVER["PATH_INFO"])) {
    $route = $_SERVER["PATH_INFO"];
}

// bootstraping
include "../core/bootstrap.php";


// routes
if (($route == "/") || ($route == "/home")) {
    include "pages/dashboard.php";
} else if ($route == "/new") {
    include "pages/new-ticket.php";
} else if ($route == "/tickets") {
    include "pages/tickets.php";
} else if ($route == "/ticket") {
    include "pages/ticket.php";
} else if ($route == "/closed") {
    include "pages/closed.php";
} else if ($route == "/search") {
    include "pages/search.php";
} else if ($route == "/edit") {
    include "pages/edit-ticket.php";
} else if ($route == "/department") {
    include "pages/department.php";
} else if ($route == "/reply") {
    include "pages/reply.php";
} else if ($route == "/print") {
    include "pages/print.php";
}


?>