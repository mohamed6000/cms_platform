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
        if (isset($_POST["email"]) && !empty($_POST["email"])) {
            if (isset($_POST["user_name"]) && !empty($_POST["user_name"])) {
                    $updated = $account->update_by_id($_POST["first_name"], $_POST["last_name"], 
                                                    $_POST["email"], $_POST["user_name"], 
                                                    $_POST["phone"], $_POST["address"], 
                                                    $_POST["gender"], $_POST["birth_date"], 
                                                    $my_id);
                    if ($updated) {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                                Votre profile a été mis à jour
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
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