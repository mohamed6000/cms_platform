<?php
require_once("../../../core/config.php");
require_once("../../../core/database.php");
require_once("../../../core/account.php");
require_once("../../../core/site_settings.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_message = "";
    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        if ((true == str_contains($_POST["email"], "@")) && (strlen($_POST["email"]) > 2)) {
            if (isset($_POST["username"]) && !empty($_POST["username"])) {
                if (isset($_POST["password"]) && !empty($_POST["password"])) {
                    $database = new Database();
                    $account = new Account($database);
                    $site_settings = new SiteSettings($database);

                    $site_settings->update_site_name($_POST["site_name"]);
                    $site_settings->set_internal_is_setup();
                    
                    if ($account->create("", "", $_POST["username"], $_POST["email"], $_POST["password"], "", "", "", "", "admin", "activated", "")) {
                        echo "<meta http-equiv='refresh' content='0; setup-complete.html'>";
                    }
                } else {
                    $error_message = "Password is empty";
                }
            } else {
                $error_message = "Username is empty";
            }
        } else {
            $error_message = "Invalid email";
        }
    } else {
        $error_message = "Email is empty";
    }

    if (!empty($error_message)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error_message</div>";
    }
}

?>