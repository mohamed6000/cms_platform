<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");
    require_once("../../core/site_settings.php");

    $database = new Database();
    $site_settings = new SiteSettings($database);
    
    $published = $site_settings->get_published_state();
    $site_settings->set_published_state(!$published);

    if ($published) {
        echo '<input pt-post="api/publish_site.php" pt-include="#published" pt-target="#checked_status" class="form-check-input" type="checkbox" id="published" name="published" role="switch"> Brouillon';
    } else {
        echo '<input pt-post="api/publish_site.php" pt-include="#published" pt-target="#checked_status" class="form-check-input" type="checkbox" id="published" name="published" role="switch" checked> Public';
    }
}

?>