<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../../core/bootstrap.php");
    require_once("render-technician-row.php");

    // Utils::begin_session();
    session_start();

    if (isset($_SESSION["admin_id"])) {
        $database = new Database();
        $account = new Account($database);

        if (isset($_POST["id"])) {
            if ($account->permanently_delete($_POST["id"])) {
                echo '<div class="alert alert-success alert-dismissible" role="alert">
                        L\'utilisateur a été supprimé.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';

                include "draw-search-delete-user-form.php";
            }
        }
    }
}

?>