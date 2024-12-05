<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");
    require_once("../../core/site_settings.php");

    session_start();
    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $site_settings = new SiteSettings($database);
    
        $visible = $site_settings->get_store_discount_state();
        $site_settings->set_store_discount_state(!$visible);

        if ($visible == 1) {
            echo '<input pt-post="api/show-store-discount.php"
                         pt-include="#show_store_discount"
                         pt-target="#checked_status" 
                         class="form-check-input" type="checkbox" id="show_store_discount"
                         name="show_store_discount" role="switch"> Non';
        } else {
            echo '<input pt-post="api/show-store-discount.php"
                         pt-include="#show_store_discount"
                         pt-target="#checked_status"
                         class="form-check-input" type="checkbox" id="show_store_discount"
                         name="show_store_discount" role="switch" checked> Oui';
        }
    }
}

?>