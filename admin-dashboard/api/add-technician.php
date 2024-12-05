<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    // Utils::begin_session();
    session_start();

    $database = new Database();
    $site_settings = new SiteSettings($database);
    $account = new Account($database);

    $message = "";
    if (isset($_SESSION["admin_id"])) {
        if (isset($_POST["email"]) && !empty($_POST["email"])) {
            if (isset($_POST["user_name"]) && !empty($_POST["user_name"])) {
                if (isset($_POST["password"]) && !empty($_POST["password"])) {
                    if (isset($_POST["password2"]) && !empty($_POST["password2"])) {
                        if ($_POST["password"] == $_POST["password2"]) {
                            $state = "waiting";
                            if (isset($_POST["state"])) {
                                $state = "activated";
                            }
                            $added = $account->create($_POST["first_name"], $_POST["last_name"], 
                                                      $_POST["user_name"], $_POST["email"], 
                                                      $_POST["password"], $_POST["phone"], 
                                                      $_POST["address"], $_POST["gender"], 
                                                      $_POST["birth_date"], "technician",
                                                      $state, $site_settings->get_email_sender());
                            if ($added === true) {
                                echo '<div class="alert alert-success alert-dismissible" role="alert">
                                        Le compte technicien a été créé et un email a été envoyé à son coursier
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                            } else {
                                $message = $added;
                            }
                        } else {
                            $message = "Confirmer le mot de passe";
                        }
                    } else {
                        $message = "Confirm mot de passe invalid";
                    }
                } else {
                    $message = "Mot de passe invalid";
                }
            } else {
                $message = "Nom d'utilisateur est invalid";
            }
        } else {
            $message = "Email invalid";
        }
    } else {
        return "L'accès non autorisé.";
    }

    if (!empty($message)) {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

?>