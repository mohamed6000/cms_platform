<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../core/bootstrap.php");

    $error_message = "";

    if (isset($_POST["first_name"]) && !empty($_POST["first_name"])) {
        if (isset($_POST["last_name"]) && !empty($_POST["last_name"])) {
            if (isset($_POST["email"]) && !empty($_POST["email"])) {
                if (isset($_POST["user_name"]) && !empty($_POST["user_name"])) {
                    if (isset($_POST["password"]) && !empty($_POST["password"])) {
                        if (strlen($_POST["password"]) >= 6) {
                            if (isset($_POST["password2"]) && !empty($_POST["password2"])) {
                                if ($_POST["password"] == $_POST["password2"]) {
                                    $database = new Database();
                                    $site_settings = new SiteSettings($database);
                                    $account = new Account($database);
                                    $notification = new Notification($database);

                                    $result = $account->create($_POST["first_name"], $_POST["last_name"],
                                                               $_POST["user_name"], $_POST["email"],
                                                               $_POST["password"], "", "", "", "", "client", "pending", 
                                                               $site_settings->get_email_sender());
                                    if ($result === true) {
                                        $notification->push("Nouvel utilisateur rejoint", 
                                                            "@" . $_POST["user_name"] ." a rejoint et doit être approuvé.", 
                                                            "update-user.php?id=" . $account->get_last_inserted_id(),
                                                             Utils::get_user_avatar_from_email($_POST["email"], 200, "robohash"));
                                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                                                  Votre compte a été créé, vous ne pouvez pas vous connecter tant que l\'administrateur n\'a pas approuvé votre compte, vous en serez informé.
                                                  <button type="button" class="close btn-close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>';
                                    } else {
                                        $error_message = $result;
                                    }
                                } else {
                                    $error_message = "Confirmer mot de passe";
                                }
                            } else {
                                $error_message = "Confirmer mot de passe est vide";
                            }
                        } else {
                            $error_message = "Mot de passe court (6 char min)";
                        }
                    } else {
                        $error_message = "Le mot de passe est vide";
                    }
                } else {
                    $error_message = "Le nom d'utilisateur est vide";
                }
            } else {
                $error_message = "Email est vide";
            }
        } else {
            $error_message = "Nom est vide";
        }
    } else {
        $error_message = "Prénom est vide";
    }

    if (!empty($error_message)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error_message</div>";
    }
}

?>