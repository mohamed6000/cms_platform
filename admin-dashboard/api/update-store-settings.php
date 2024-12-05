<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    session_start();
    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $site_settings = new SiteSettings($database);

        $updated = $site_settings->update_store_discount($_POST["store_discount_percent"], 
                                                     $_POST["store_discount_event_name"],
                                                     $_POST["store_discount_date_limit"]);
        if ($updated) {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
                    Paramétres de boutique sont mis à jour
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    }
}

?>