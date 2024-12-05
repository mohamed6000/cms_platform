<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");
    session_start();

    $database = new Database();
    $site_settings = new SiteSettings($database);

    if (isset($_SESSION["admin_id"])) {
        if (isset($_FILES["logo"]["tmp_name"]) && !(empty($_FILES["logo"]["tmp_name"]))) {
            if (Utils::is_the_mime_image($_FILES["logo"]["type"])) {
                $check = getimagesize($_FILES["logo"]["tmp_name"]);
                if ($check != false) {
                    $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
                    $target = "/uploads/logo.".$ext;
                    $updated = $site_settings->update_logo($target);
                    if ($updated) {
                        move_uploaded_file($_FILES["logo"]["tmp_name"], "../..".$target);

                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                                    Votre logo a été mis à jour.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                               </div>';
                    }
                }
            }
        }
    }
}

?>