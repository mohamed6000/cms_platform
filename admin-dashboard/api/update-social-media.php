<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    $database = new Database();
    $site_settings = new SiteSettings($database);

    session_start();
    if (isset($_SESSION["admin_id"])) {
        $updated = $site_settings->update_socials($_POST["social_facebook"], 
                                                  $_POST["social_twitter"],
                                                  $_POST["social_youtube"],
                                                  $_POST["social_instagram"],
                                                  $_POST["social_pinterest"]);
        if ($updated) {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
                    Les réseaux sociaux sont à jour
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    }
}

?>