<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    // Utils::begin_session();
    session_start();

    $message = "";

    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $account = new Account($database);

        if (isset($_GET["id"])) {
            $my_id = intval($_GET["id"]);
            if (isset($_POST["email"]) && !empty($_POST["email"])) {
                if (isset($_POST["user_name"]) && !empty($_POST["user_name"])) {
                    if (isset($_POST["role"]) && !empty($_POST["role"])) {
                        if (isset($_POST["password"]) && !empty($_POST["password"])) {
                            if (isset($_POST["password2"]) && !empty($_POST["password2"])) {
                                if ($_POST["password"] == $_POST["password2"]) {
                                    // update account with password
                                    if ($account->update_with_state_new_password_by_id($_POST["first_name"], 
                                        $_POST["last_name"],
                                        $_POST["email"], $_POST["user_name"],
                                        $_POST["phone"], $_POST["address"],
                                        $_POST["gender"], $_POST["birth_date"],
                                        $_POST["password"], $_POST["state"], $my_id)) {
                                        if ($account->update_role($_POST["role"], $my_id)) {
                                            echo '<div class="alert alert-success alert-dismissible" role="alert">
                                                      Le profile a été mis à jour
                                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                  </div>';
                                        }
                                    }
                                } else {
                                    $message = "Confirmer mot de passe";
                                }
                            } else {
                                $message = "Confirme mot de passe invalid";
                            }
                        } else {
                            // update account without password
                            if ($account->update_by_id($_POST["first_name"], $_POST["last_name"],
                                                       $_POST["email"], $_POST["user_name"],
                                                       $_POST["phone"], $_POST["address"],
                                                       $_POST["gender"], $_POST["birth_date"],
                                                       $my_id)) {
                                if ($account->update_state($_POST["state"], $my_id)) {
                                    if ($account->update_role($_POST["role"], $my_id)) {
                                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                                                  Le profile a été mis à jour
                                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                              </div>';
                                    }
                                }
                            }
                        }
                    } else {
                        $message = "Le role est invalid";
                    }
                } else {
                    $message = "Nom d'utilisateur est invalid";
                }
            } else {
                $message = "Email invalid";
            }
        } else {
            $message = "Route introuvable";
        }
    }

    if (!empty($message)) {
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

?>