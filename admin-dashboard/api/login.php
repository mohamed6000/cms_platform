<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");

    $error_message = "";

    if (isset($_POST["username"]) && !empty($_POST["username"])) {
        if (isset($_POST["password"]) && !empty($_POST["password"])) {
            $database = new Database();
            $account = new Account($database);

            $result = $account->login_as_admin($_POST["username"], $_POST["password"]);
            if ($result === true) {
                echo "<meta http-equiv='refresh' content='0; /admin-dashboard/'>";
            } else {
                $error_message = $result;
            }
        } else {
            $error_message = "Le mot de passe est vide";
        }
    } else {
        $error_message = "Le nom d'utilisateur est vide";
    }

    if (!empty($error_message)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error_message</div>";
    }
}

?>