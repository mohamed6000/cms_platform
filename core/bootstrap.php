<?php

// check if config file exists
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/core/config.php") == true) { // file_exists requires full directory from base
    require_once("config.php");
    require_once("database.php");
    require_once("account.php");
    require_once("site_settings.php");
    require_once("notification.php");
    require_once("ticket.php");
    require_once("store_product.php");

    $template = "themes/ashion-master/";
} else {
    // config file doesn't exist
    $message = "";
    // setup database and configure the script
    header("Location: ../../services/install/setup.php");
}

?>