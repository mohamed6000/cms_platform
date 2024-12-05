<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    $database = new Database();
    $site_settings = new SiteSettings($database);

    $message = "";
    if (isset($_POST["site_name"]) && !empty($_POST["site_name"])) {
        if (isset($_POST["base_url"]) && !empty($_POST["base_url"])) {
            $updated = $site_settings->update($_POST["site_name"], $_POST["base_url"],
                                              $_POST["email"], $_POST["phone"], 
                                              $_POST["timing"], $_POST["address"], 
                                              $_POST["description"], $_POST["keywords"]);
            if ($updated) {
                echo '<div class="alert alert-success alert-dismissible" role="alert">
                        Site a été mis à jour
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        } else {
            $message = "L'URL de site est invalid";
        }
    } else {
        $message = "Nom de site invalid";
    }

    if (!empty($message)) {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

?>