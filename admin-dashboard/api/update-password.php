<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    // Utils::begin_session();
    session_start();

    $database = new Database();
    $account = new Account($database);

    $message = "";

    $my_id = false;
    if (isset($_SESSION["admin_id"])) {
        $my_id = $_SESSION["admin_id"];
    }

    if ($my_id) {
        if (isset($_POST["old_password"]) && !empty($_POST["old_password"])) {
            if (isset($_POST["new_password"]) && !empty($_POST["new_password"])) {
                if (strlen($_POST["new_password"]) >= 6) {
                    if (isset($_POST["new_password2"]) && !empty($_POST["new_password2"])) {
                        if ($_POST["new_password"] == $_POST["new_password2"]) {
                            // check if the new password is the same as the old one, update
                            $result = $account->update_password_by_id($_POST["old_password"], $_POST["new_password"], $my_id);
                            if ($result === true) {
                                echo '<div class="alert alert-success alert-dismissible" role="alert">
                                Votre mot de passe a été mis à jour
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            } else {
                                $message = $result;
                            }
                        } else {
                            $message = "Les mots de passe ne correspondent pas";
                        }
                    } else {
                        $message = "Confirmer votre mot de passe";
                    }
                } else {
                    $message = "Votre nouveau mot de passe est trop court";
                }
            } else {
                $message = "Nouveau mot de passe invalide";
            }
        } else {
            $message = "Mot de passe précédent invalide";
        }

        if (!empty($message)) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    '.$message.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    }
}

?>